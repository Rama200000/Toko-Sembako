<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->orderBy('name')->get();

        return view('sales.index', [
            'products' => $products,
            'productOptions' => $products->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
            ])->values(),
            'sales' => Sale::with('items')->latest('sold_at')->limit(20)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:100'],
            'sold_at' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $productIds = collect($validated['items'])->pluck('product_id')->all();
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $grandTotal = 0;
            $saleItems = [];

            foreach ($validated['items'] as $item) {
                $product = $products->get($item['product_id']);
                $qty = (int) $item['qty'];

                if (! $product || $product->stock < $qty) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'items' => "Stok produk {$product?->name} tidak mencukupi.",
                    ]);
                }

                $subtotal = $product->price * $qty;
                $grandTotal += $subtotal;

                $saleItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $qty);
            }

            $sale = Sale::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT),
                'customer_name' => $validated['customer_name'] ?: 'Umum',
                'sold_at' => $validated['sold_at'],
                'grand_total' => $grandTotal,
            ]);

            $sale->items()->createMany($saleItems);
        });

        return back()->with('success', 'Transaksi penjualan berhasil disimpan.');
    }
}

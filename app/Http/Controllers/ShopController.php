<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    private function storefrontProducts()
    {
        return Product::query()
            ->latest()
            ->get();
    }

    public function home()
    {
        $products = $this->storefrontProducts();

        return view('shop.home', [
            'featuredProducts' => $products,
        ]);
    }

    public function categories()
    {
        $categories = Product::query()
            ->select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('shop.categories', [
            'categories' => $categories,
            'products' => $this->storefrontProducts(),
        ]);
    }

    public function cart()
    {
        $cart = collect(session('shop_cart', []));

        $items = Product::query()
            ->whereIn('id', $cart->keys()->all())
            ->get()
            ->map(function (Product $product) use ($cart) {
                $qty = (int) ($cart[$product->id] ?? 0);

                return (object) [
                    'id' => $product->id,
                    'name' => $product->name,
                    'unit' => $product->unit,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $product->price * $qty,
                ];
            })
            ->filter(fn ($item) => $item->qty > 0)
            ->values();

        $subtotal = $items->sum('subtotal');
        $shipping = $subtotal > 0 ? 10000 : 0;

        return view('shop.cart', [
            'items' => $items,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
        ]);
    }

    public function addToCart(Product $product): RedirectResponse
    {
        if ($product->stock < 1) {
            return back()->withErrors(['cart' => 'Stok produk habis.']);
        }

        $cart = collect(session('shop_cart', []));
        $currentQty = (int) ($cart[$product->id] ?? 0);
        $newQty = min($currentQty + 1, $product->stock);

        $cart[$product->id] = $newQty;
        session(['shop_cart' => $cart->all()]);

        return redirect()->route('shop.cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = collect(session('shop_cart', []));
        $cart[$product->id] = min((int) $validated['qty'], $product->stock);

        if ((int) $cart[$product->id] < 1) {
            $cart->forget($product->id);
        }

        session(['shop_cart' => $cart->all()]);

        return back()->with('success', 'Jumlah produk di keranjang diperbarui.');
    }

    public function removeFromCart(Product $product): RedirectResponse
    {
        $cart = collect(session('shop_cart', []));
        $cart->forget($product->id);

        session(['shop_cart' => $cart->all()]);

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkoutWhatsapp(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:300'],
            'notes' => ['nullable', 'string', 'max:300'],
        ]);

        $cart = collect(session('shop_cart', []));

        if ($cart->isEmpty()) {
            return back()->withErrors(['cart' => 'Keranjang masih kosong.']);
        }

        $checkout = DB::transaction(function () use ($cart, $validated) {
            $products = Product::query()
                ->whereIn('id', $cart->keys()->all())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => 'Produk keranjang tidak ditemukan.',
                ]);
            }

            $lines = [];
            $saleItems = [];
            $subtotal = 0;

            foreach ($cart as $productId => $cartQty) {
                $product = $products->get((int) $productId);
                $qty = (int) $cartQty;

                if (! $product || $qty < 1) {
                    continue;
                }

                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'cart' => "Stok produk {$product->name} tidak mencukupi.",
                    ]);
                }

                $itemSubtotal = $qty * $product->price;
                $subtotal += $itemSubtotal;

                $saleItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $itemSubtotal,
                ];

                $lines[] = sprintf(
                    '- %s x%d (%s) = Rp %s',
                    $product->name,
                    $qty,
                    $product->unit,
                    number_format($itemSubtotal, 0, ',', '.')
                );

                $product->decrement('stock', $qty);
            }

            if (empty($saleItems)) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang masih kosong.',
                ]);
            }

            $shipping = $subtotal > 0 ? 10000 : 0;
            $total = $subtotal + $shipping;

            $sale = Sale::create([
                'invoice_number' => 'INV-' . now()->format('YmdHis') . '-' . str_pad((string) random_int(1, 999), 3, '0', STR_PAD_LEFT),
                'customer_name' => $validated['customer_name'],
                'sold_at' => now(),
                'grand_total' => $total,
            ]);

            $sale->items()->createMany($saleItems);

            return [
                'sale' => $sale,
                'lines' => $lines,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
            ];
        });

        $orderIds = collect(session('shop_order_ids', []));
        $orderIds->prepend($checkout['sale']->id);
        session([
            'shop_order_ids' => $orderIds->unique()->take(30)->values()->all(),
            'shop_cart' => [],
        ]);

        $messageText = "Halo Admin, saya ingin pesan sembako.\n"
            . "\nNomor Pesanan: {$checkout['sale']->invoice_number}"
            . "\nNama: {$validated['customer_name']}"
            . "\nAlamat: {$validated['address']}"
            . "\n\nDetail Pesanan:\n" . implode("\n", $checkout['lines'])
            . "\n\nSubtotal: Rp " . number_format($checkout['subtotal'], 0, ',', '.')
            . "\nOngkir: Rp " . number_format($checkout['shipping'], 0, ',', '.')
            . "\nTotal: Rp " . number_format($checkout['total'], 0, ',', '.');

        if (!empty($validated['notes'])) {
            $messageText .= "\nCatatan: {$validated['notes']}";
        }

        $whatsAppNumber = '6287776945300';
        $url = 'https://wa.me/' . $whatsAppNumber . '?text=' . rawurlencode($messageText);

        return redirect()->away($url);
    }

    public function orders()
    {
        $orderIds = collect(session('shop_order_ids', []));

        return view('shop.orders', [
            'orders' => Sale::with('items')
                ->whereIn('id', $orderIds->all())
                ->latest('sold_at')
                ->get(),
        ]);
    }
}

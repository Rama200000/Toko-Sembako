<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $todaySales = Sale::query()
            ->whereDate('sold_at', now()->toDateString())
            ->sum('grand_total');

        $data = [
            'productCount' => Product::count(),
            'lowStockCount' => Product::where('stock', '<=', 10)->count(),
            'todaySales' => $todaySales,
            'totalSales' => Sale::sum('grand_total'),
            'latestSales' => Sale::latest('sold_at')->limit(5)->get(),
        ];

        return view('dashboard', $data);
    }
}

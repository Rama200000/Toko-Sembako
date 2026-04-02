@extends('layouts.admin')

@section('content')
<div class="bg-gradient-to-r from-pink-700 via-fuchsia-700 to-rose-700 text-white rounded-2xl p-5 shadow-soft mb-6">
    <p class="text-xs uppercase tracking-[0.2em] text-pink-100">Dashboard</p>
    <h2 class="text-2xl md:text-3xl font-bold">Selamat datang di panel toko</h2>
    <p class="text-sm text-pink-100 mt-1">Pantau performa penjualan, stok, dan aktivitas kasir dalam satu layar.</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="floating bg-white rounded-2xl p-4 shadow-soft border border-slate-100">
        <p class="text-sm text-slate-500">📦 Total Produk</p>
        <p class="text-3xl font-bold mt-1">{{ $productCount }}</p>
    </div>
    <div class="floating float-delay-1 bg-white rounded-2xl p-4 shadow-soft border border-slate-100">
        <p class="text-sm text-slate-500">⚠️ Stok Menipis (≤10)</p>
        <p class="text-3xl font-bold text-pink-600 mt-1">{{ $lowStockCount }}</p>
    </div>
    <div class="floating float-delay-2 bg-white rounded-2xl p-4 shadow-soft border border-slate-100">
        <p class="text-sm text-slate-500">💵 Penjualan Hari Ini</p>
        <p class="text-2xl font-bold text-fuchsia-700 mt-1">Rp {{ number_format($todaySales, 0, ',', '.') }}</p>
    </div>
    <div class="floating floating-slow bg-white rounded-2xl p-4 shadow-soft border border-slate-100">
        <p class="text-sm text-slate-500">🏆 Total Omzet</p>
        <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-soft overflow-hidden border border-slate-100">
    <div class="px-4 py-3 border-b font-semibold bg-slate-50">Transaksi Terakhir</div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-4 py-2">Invoice</th>
                <th class="text-left px-4 py-2">Pelanggan</th>
                <th class="text-left px-4 py-2">Tanggal</th>
                <th class="text-right px-4 py-2">Total</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($latestSales as $sale)
                <tr class="border-t hover:bg-slate-50/70 transition">
                    <td class="px-4 py-2">{{ $sale->invoice_number }}</td>
                    <td class="px-4 py-2">{{ $sale->customer_name }}</td>
                    <td class="px-4 py-2">{{ $sale->sold_at?->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2 text-right">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-3 text-slate-500" colspan="4">Belum ada transaksi.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 bg-white rounded-2xl shadow-soft overflow-hidden border border-slate-100">
    <div class="px-4 py-3 border-b font-semibold bg-slate-50">Detail Menu</div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-4 py-2">Menu</th>
                <th class="text-left px-4 py-2">Fungsi</th>
                <th class="text-left px-4 py-2">Kapan Dipakai</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-t">
                <td class="px-4 py-2 font-medium">Dashboard</td>
                <td class="px-4 py-2">Menampilkan ringkasan omzet, stok menipis, dan transaksi terbaru.</td>
                <td class="px-4 py-2">Saat cek kondisi toko secara cepat.</td>
            </tr>
            <tr class="border-t">
                <td class="px-4 py-2 font-medium">Produk</td>
                <td class="px-4 py-2">Kelola data barang: tambah, edit, hapus, dan update stok awal.</td>
                <td class="px-4 py-2">Saat ada barang baru atau perubahan harga/stok.</td>
            </tr>
            <tr class="border-t">
                <td class="px-4 py-2 font-medium">Penjualan</td>
                <td class="px-4 py-2">Input transaksi pelanggan, simpan item belanja, dan lihat riwayat transaksi.</td>
                <td class="px-4 py-2">Setiap ada transaksi kasir.</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

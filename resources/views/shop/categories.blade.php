@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-3xl border border-violet-200 bg-gradient-to-r from-violet-50 via-fuchsia-50 to-indigo-50 p-5 md:p-6 shadow-soft">
        <p class="text-xs uppercase tracking-[0.2em] text-violet-700">Kategori Belanja</p>
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 mt-1">Temukan Produk Lebih Cepat</h2>
        <p class="text-sm text-slate-600 mt-2 max-w-2xl">
            Fitur kategori sangat membantu pembeli saat produk makin banyak. Kamu bisa langsung lompat ke kelompok barang yang dibutuhkan tanpa scroll panjang.
        </p>

        <div class="grid sm:grid-cols-3 gap-3 mt-4">
            <div class="rounded-xl bg-white/90 border border-white p-3">
                <p class="text-xs text-slate-500">Total Kategori</p>
                <p class="text-2xl font-extrabold text-slate-800">{{ $categories->count() }}</p>
            </div>
            <div class="rounded-xl bg-white/90 border border-white p-3">
                <p class="text-xs text-slate-500">Produk Ditampilkan</p>
                <p class="text-2xl font-extrabold text-slate-800">{{ $products->count() }}</p>
            </div>
            <div class="rounded-xl bg-white/90 border border-white p-3">
                <p class="text-xs text-slate-500">Rata-rata / Kategori</p>
                <p class="text-2xl font-extrabold text-slate-800">
                    {{ $categories->count() > 0 ? number_format($products->count() / $categories->count(), 1) : '0.0' }}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-3xl shadow-soft overflow-hidden border border-slate-100">
        <div class="px-4 py-3 border-b font-semibold bg-slate-50">Produk Berdasarkan Kategori</div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
            @forelse($products as $product)
                <article class="border border-slate-200 rounded-2xl p-4 bg-white hover:shadow-md transition">
                    @if ($product->photo_path)
                        <img src="{{ asset('storage/' . $product->photo_path) }}" alt="{{ $product->name }}" class="h-32 w-full rounded-xl object-cover border border-slate-200 mb-3">
                    @endif
                    <p class="inline-flex text-[10px] px-2 py-1 rounded-full bg-slate-100 text-slate-600 mb-2">{{ $product->category }}</p>
                    <p class="font-semibold text-slate-800">{{ $product->name }}</p>
                    <p class="text-xs text-slate-500 mb-2">Satuan: {{ $product->unit }}</p>
                    <p class="text-xs mb-2 {{ $product->stock > 0 ? 'text-violet-600' : 'text-rose-600' }}">
                        {{ $product->stock > 0 ? 'Stok tersedia: ' . $product->stock : 'Stok habis' }}
                    </p>
                    <p class="text-violet-700 text-lg font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                    <form method="POST" action="{{ route('shop.cart.add', $product) }}" class="mt-3">
                        @csrf
                        @if($product->stock > 0)
                            <button class="w-full rounded-xl bg-violet-600 hover:bg-violet-700 text-white py-2 text-sm font-semibold transition">
                                Tambah ke Keranjang
                            </button>
                        @else
                            <button type="button" class="w-full rounded-xl bg-slate-300 text-slate-500 py-2 text-sm font-semibold cursor-not-allowed" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </form>
                </article>
            @empty
                <p class="text-slate-500">Belum ada produk aktif.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection

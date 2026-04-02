@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap');

    .sahara-lite {
        --brand-red: #7c3aed;
        --brand-sand: #f3f0ff;
        --brand-ink: #2a2440;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>

<div class="sahara-lite space-y-6">
    <section class="relative overflow-hidden rounded-3xl bg-[radial-gradient(circle_at_top_right,_#a78bfa_0%,_#7c3aed_35%,_#4c1d95_100%)] text-white p-6 md:p-8 shadow-soft">
        <div class="absolute -top-14 -left-14 w-44 h-44 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-20 -right-8 w-52 h-52 rounded-full bg-black/10"></div>

        <div class="relative grid lg:grid-cols-3 gap-6 items-end">
            <div class="lg:col-span-2 space-y-3">
                <p class="inline-flex items-center gap-2 text-xs tracking-[0.2em] uppercase bg-white/15 border border-white/25 px-3 py-1 rounded-full">
                    Jaringan Warung Digital
                </p>
                <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">Belanja Sembako Cepat, Hangat, dan Dekat</h2>
                <p class="text-sm md:text-base text-violet-50/95 max-w-2xl">
                    Platform belanja kebutuhan harian untuk rumah tangga dan warung kecil.
                    Fokus kami: harga jelas, stok terpantau, dan pengantaran yang rapi.
                </p>

                <div class="flex flex-wrap gap-3 pt-2">
                        <a href="{{ route('shop.cart') }}" class="rounded-xl bg-white text-[color:var(--brand-red)] px-4 py-2.5 font-bold text-sm hover:bg-violet-50 transition">Belanja Sekarang</a>
                    <a href="{{ route('shop.categories') }}" class="rounded-xl border border-white/60 text-white px-4 py-2.5 font-semibold text-sm hover:bg-white/10 transition">Jelajahi Kategori</a>
                </div>
            </div>

            <div class="floating rounded-2xl bg-white/95 text-[color:var(--brand-ink)] p-4 border border-white/80 shadow-xl">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Ringkas Hari Ini</p>
                <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                    <div class="rounded-xl bg-[color:var(--brand-sand)] p-3">
                        <p class="text-slate-500 text-xs">Total Produk</p>
                        <p class="text-xl font-extrabold">{{ $featuredProducts->count() }}</p>
                    </div>
                    <div class="rounded-xl bg-[color:var(--brand-sand)] p-3">
                        <p class="text-slate-500 text-xs">Kategori Aktif</p>
                        <p class="text-xl font-extrabold">{{ $featuredProducts->pluck('category')->unique()->count() }}</p>
                    </div>
                </div>
                <a href="{{ route('shop.cart') }}" class="mt-3 block text-center rounded-xl bg-[color:var(--brand-red)] text-white px-3 py-2 font-semibold text-sm hover:opacity-95 transition">
                    Buka Keranjang
                </a>
            </div>
        </div>
    </section>

    <section class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <a href="{{ route('shop.categories') }}" class="floating rounded-2xl border border-violet-200 bg-white p-4 hover:-translate-y-1 transition shadow-soft">
                <p class="text-xs uppercase tracking-[0.2em] text-violet-700">01</p>
            <h3 class="mt-1 font-bold text-slate-800">Kategori Rapi</h3>
            <p class="text-sm text-slate-500 mt-1">Kebutuhan dibagi per kelompok agar belanja lebih cepat.</p>
        </a>
        <a href="#produk-unggulan" class="floating float-delay-1 rounded-2xl border border-fuchsia-200 bg-white p-4 hover:-translate-y-1 transition shadow-soft">
                <p class="text-xs uppercase tracking-[0.2em] text-fuchsia-700">02</p>
            <h3 class="mt-1 font-bold text-slate-800">Produk Pilihan</h3>
            <p class="text-sm text-slate-500 mt-1">Daftar produk yang paling sering dicari pembeli.</p>
        </a>
        <a href="{{ route('shop.orders') }}" class="floating float-delay-2 rounded-2xl border border-indigo-200 bg-white p-4 hover:-translate-y-1 transition shadow-soft">
                <p class="text-xs uppercase tracking-[0.2em] text-indigo-700">03</p>
            <h3 class="mt-1 font-bold text-slate-800">Riwayat Pesanan</h3>
            <p class="text-sm text-slate-500 mt-1">Pantau status pesanan lama tanpa perlu cari manual.</p>
        </a>
        <a href="{{ route('shop.cart') }}" class="floating floating-slow rounded-2xl border border-purple-200 bg-white p-4 hover:-translate-y-1 transition shadow-soft">
                <p class="text-xs uppercase tracking-[0.2em] text-purple-700">04</p>
            <h3 class="mt-1 font-bold text-slate-800">Keranjang Belanja</h3>
            <p class="text-sm text-slate-500 mt-1">Cek item belanja dan lanjut checkout ke WhatsApp.</p>
        </a>
    </section>

    <section class="bg-white rounded-3xl border border-slate-200 shadow-soft p-5 md:p-6">
        <div class="flex items-center justify-between gap-3 mb-4">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Harga Spesial</p>
                <h3 class="text-xl font-extrabold text-slate-800">Produk Rekomendasi Minggu Ini</h3>
            </div>
            <a href="{{ route('shop.categories') }}" class="text-sm font-semibold text-[color:var(--brand-red)]">Lihat semua kategori</a>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            @forelse($featuredProducts->take(4) as $product)
                <article class="rounded-2xl border border-violet-100 bg-gradient-to-b from-violet-50 to-white p-4">
                    @if ($product->photo_path)
                        <img src="{{ asset('storage/' . $product->photo_path) }}" alt="{{ $product->name }}" class="h-32 w-full rounded-xl object-cover border border-violet-100 mb-3">
                    @endif
                    <p class="text-xs text-violet-700 font-semibold uppercase tracking-wide">Best Pick</p>
                    <h4 class="mt-1 font-bold text-slate-800 line-clamp-2">{{ $product->name }}</h4>
                    <p class="text-xs text-slate-500 mt-1">{{ $product->category }} • {{ $product->unit }}</p>
                    <div class="mt-3">
                        <p class="text-lg font-extrabold text-violet-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Belum ada produk aktif.</p>
            @endforelse
        </div>
    </section>

    <section id="produk-unggulan" class="bg-white rounded-3xl border border-slate-200 shadow-soft p-5 md:p-6">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Katalog Utama</p>
            <h3 class="text-xl font-extrabold text-slate-800 mt-1 mb-4">Produk Unggulan</h3>

            <div class="grid sm:grid-cols-2 gap-4">
                @forelse($featuredProducts as $product)
                    <article class="rounded-2xl border border-slate-200 p-4 hover:shadow-md transition">
                        @if ($product->photo_path)
                            <img src="{{ asset('storage/' . $product->photo_path) }}" alt="{{ $product->name }}" class="h-36 w-full rounded-xl object-cover border border-slate-200 mb-3">
                        @endif
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $product->name }}</h4>
                                <p class="text-xs text-slate-500 mt-0.5">{{ $product->category }} • {{ $product->unit }}</p>
                            </div>
                            <span class="text-xs font-semibold rounded-full px-2 py-1 {{ $product->stock > 0 ? 'bg-violet-100 text-violet-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $product->stock > 0 ? 'Stok ' . $product->stock : 'Stok Habis' }}
                            </span>
                        </div>
                        <p class="mt-4 text-lg font-extrabold text-violet-700">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
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
                    <p class="text-slate-500">Belum ada produk. Isi data produk dari dashboard admin.</p>
                @endforelse
            </div>
    </section>

    <section class="grid xl:grid-cols-2 gap-5">
        <div class="floating bg-white rounded-3xl border border-slate-200 shadow-soft p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Ulasan Mitra</p>
            <h3 class="text-lg font-extrabold text-slate-800 mt-1">Testimoni Ringkas</h3>

            <div class="mt-4 space-y-3 text-sm">
                <blockquote class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                    <p class="font-semibold">"Harga jelas, stok sesuai, kirim cepat."</p>
                    <p class="text-xs text-slate-500 mt-1">Warung Barokah, Bekasi</p>
                </blockquote>
                <blockquote class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                    <p class="font-semibold">"Enak buat belanja harian karena kategori rapi."</p>
                    <p class="text-xs text-slate-500 mt-1">Ibu Rini, Tangerang</p>
                </blockquote>
                <blockquote class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                    <p class="font-semibold">"Pilihan barangnya jelas dan mudah dicari."</p>
                    <p class="text-xs text-slate-500 mt-1">Toko Maju Jaya, Depok</p>
                </blockquote>
            </div>
        </div>

        <div class="floating float-delay-1 bg-[color:var(--brand-sand)] rounded-3xl border border-violet-200 p-5">
            <p class="text-xs uppercase tracking-[0.2em] text-violet-800">Mulai Sekarang</p>
            <h3 class="text-lg font-extrabold text-[color:var(--brand-ink)] mt-1">Pesan Dari HP, Antar ke Rumah</h3>
            <p class="text-sm text-slate-700 mt-2">Buka keranjang dan checkout dalam hitungan menit.</p>
            <a href="{{ route('shop.cart') }}" class="mt-4 inline-block rounded-xl bg-[color:var(--brand-red)] text-white px-4 py-2.5 text-sm font-semibold hover:opacity-95 transition">Lanjut ke Keranjang</a>
        </div>
    </section>
</div>
@endsection

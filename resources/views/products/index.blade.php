@extends('layouts.admin')

@section('content')
<div class="bg-gradient-to-r from-pink-700 to-fuchsia-700 text-white rounded-2xl p-5 shadow-soft mb-6">
    <p class="text-xs uppercase tracking-[0.2em] text-pink-100">Manajemen Produk</p>
    <h2 class="text-2xl font-bold">Kelola stok sembako lebih rapi</h2>
    <p class="text-sm text-pink-100">Tambah produk baru, atur harga, dan update stok secara cepat.</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow-soft p-5 border border-slate-100">
        <h2 class="font-semibold mb-3 text-lg">Tambah Produk</h2>
        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-3" enctype="multipart/form-data">
            @csrf
            <input name="name" placeholder="Nama produk" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" required>
            <input name="category" placeholder="Kategori" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" required>
            <div class="grid grid-cols-2 gap-2">
                <input name="unit" placeholder="Satuan (kg/pcs)" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" required>
                <input type="number" name="stock" placeholder="Stok" min="0" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" required>
            </div>
            <input type="number" name="price" placeholder="Harga" min="0" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" required>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Foto Produk</label>
                <input type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm">
                <p class="text-xs text-slate-500 mt-1">Opsional. Format: JPG, PNG, WEBP. Maks 2MB.</p>
            </div>
            <button class="w-full bg-gradient-to-r from-pink-700 to-fuchsia-700 text-white rounded-xl px-4 py-2.5 font-medium hover:opacity-95">Simpan Produk</button>
        </form>
    </div>

    <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft overflow-hidden border border-slate-100">
        <div class="px-4 py-3 border-b font-semibold bg-slate-50">Daftar Produk</div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-3 py-2">Nama</th>
                    <th class="text-left px-3 py-2">Foto</th>
                    <th class="text-left px-3 py-2">Kategori</th>
                    <th class="text-right px-3 py-2">Harga</th>
                    <th class="text-right px-3 py-2">Stok</th>
                    <th class="text-center px-3 py-2">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr class="border-t align-top hover:bg-slate-50/70 transition">
                        <td class="px-3 py-2">
                            <span class="font-medium">{{ $product->name }}</span>
                            <div class="text-xs text-slate-500">{{ $product->unit }}</div>
                        </td>
                        <td class="px-3 py-2">
                            @if ($product->photo_path)
                                <img src="{{ asset('storage/' . $product->photo_path) }}" alt="{{ $product->name }}" class="h-12 w-12 rounded-lg object-cover border border-slate-200">
                            @else
                                <div class="h-12 w-12 rounded-lg border border-dashed border-slate-300 bg-slate-50 text-[10px] text-slate-400 grid place-items-center">No Img</div>
                            @endif
                        </td>
                        <td class="px-3 py-2">{{ $product->category }}</td>
                        <td class="px-3 py-2 text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-3 py-2 text-right">{{ $product->stock }}</td>
                        <td class="px-3 py-2">
                            <div class="flex items-center justify-center gap-2">
                                <details class="group">
                                    <summary class="list-none cursor-pointer px-3 py-1.5 bg-fuchsia-700 text-white rounded-lg text-xs">Edit</summary>
                                    <form action="{{ route('admin.products.update', $product) }}" method="POST" class="mt-2 space-y-2 w-72 p-3 rounded-xl border border-slate-200 bg-white shadow" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-2 gap-1">
                                            <input name="name" value="{{ $product->name }}" class="border border-slate-200 rounded-lg px-2 py-1">
                                            <input name="category" value="{{ $product->category }}" class="border border-slate-200 rounded-lg px-2 py-1">
                                            <input name="unit" value="{{ $product->unit }}" class="border border-slate-200 rounded-lg px-2 py-1">
                                            <input type="number" min="0" name="stock" value="{{ $product->stock }}" class="border border-slate-200 rounded-lg px-2 py-1">
                                            <input type="number" min="0" name="price" value="{{ $product->price }}" class="border border-slate-200 rounded-lg px-2 py-1 col-span-2">
                                            <input type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="border border-slate-200 rounded-lg px-2 py-1 col-span-2 text-xs">
                                            @if ($product->photo_path)
                                                <label class="text-xs text-slate-600 col-span-2 inline-flex items-center gap-2">
                                                    <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300">
                                                    Hapus foto saat ini
                                                </label>
                                            @endif
                                        </div>
                                        <button class="w-full px-3 py-1.5 bg-fuchsia-700 text-white rounded-lg text-xs">Simpan Perubahan</button>
                                    </form>
                                </details>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus produk ini?')" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs">Hapus</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-3 py-3 text-slate-500" colspan="6">Belum ada produk.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

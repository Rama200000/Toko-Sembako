@extends('layouts.admin')

@section('content')
<div class="bg-gradient-to-r from-pink-700 to-fuchsia-700 text-white rounded-2xl p-5 shadow-soft mb-6">
    <p class="text-xs uppercase tracking-[0.2em] text-pink-100">Kasir</p>
    <h2 class="text-2xl font-bold">Input transaksi penjualan</h2>
    <p class="text-sm text-pink-100">Catat penjualan harian, update stok otomatis, dan pantau riwayat transaksi.</p>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl shadow-soft p-5 lg:col-span-1 border border-slate-100">
        <h2 class="font-semibold mb-3 text-lg">Input Transaksi</h2>
        <form action="{{ route('admin.sales.store') }}" method="POST" class="space-y-3" id="sale-form">
            @csrf
            <input type="text" name="customer_name" placeholder="Nama pelanggan (opsional)" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2">
            <input type="datetime-local" name="sold_at" class="w-full border border-slate-200 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-3 py-2" value="{{ now()->format('Y-m-d\\TH:i') }}" required>

            <div id="item-wrapper" class="space-y-2"></div>

            <button type="button" onclick="addItem()" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3 py-2 hover:bg-slate-200">+ Tambah Item</button>
            <button class="w-full bg-gradient-to-r from-pink-700 to-fuchsia-700 text-white rounded-xl px-3 py-2.5 font-medium hover:opacity-95">Simpan Transaksi</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-soft overflow-hidden lg:col-span-2 border border-slate-100">
        <div class="px-4 py-3 border-b font-semibold bg-slate-50">Riwayat Penjualan</div>
        <div class="divide-y max-h-[620px] overflow-y-auto">
            @forelse($sales as $sale)
                <div class="p-4 hover:bg-slate-50/70 transition">
                    <div class="flex justify-between text-sm">
                        <div>
                            <p class="font-semibold">{{ $sale->invoice_number }}</p>
                            <p class="text-slate-500">{{ $sale->customer_name }} • {{ $sale->sold_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</p>
                    </div>
                    <ul class="mt-2 text-sm text-slate-600 list-disc pl-5">
                        @foreach($sale->items as $item)
                            <li>{{ $item->product_name }} x {{ $item->qty }} = Rp {{ number_format($item->subtotal, 0, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="p-4 text-slate-500">Belum ada transaksi.</div>
            @endforelse
        </div>
    </div>
</div>

<script>
    const products = @json($productOptions);

    let row = 0;

    function addItem() {
        row++;
        const wrapper = document.getElementById('item-wrapper');
        const options = products.map(p => `<option value="${p.id}">${p.name} (stok: ${p.stock})</option>`).join('');

        wrapper.insertAdjacentHTML('beforeend', `
            <div class="grid grid-cols-12 gap-2 items-center bg-slate-50 border border-slate-200 rounded-xl p-2" id="row-${row}">
                <select name="items[${row}][product_id]" class="col-span-8 border border-slate-200 rounded-lg px-2 py-2" required>
                    <option value="">Pilih produk</option>
                    ${options}
                </select>
                <input type="number" min="1" name="items[${row}][qty]" class="col-span-3 border border-slate-200 rounded-lg px-2 py-2" placeholder="Qty" required>
                <button type="button" class="col-span-1 text-rose-600" onclick="document.getElementById('row-${row}').remove()">✕</button>
            </div>
        `);
    }

    addItem();
</script>
@endsection

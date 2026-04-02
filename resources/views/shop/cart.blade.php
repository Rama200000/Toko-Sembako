@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft overflow-hidden border border-slate-100">
        <div class="px-4 py-3 border-b font-semibold bg-slate-50">Keranjang Saya</div>
        <div class="divide-y">
            @forelse($items as $item)
                <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3 hover:bg-slate-50/60 transition">
                    <div class="min-w-0">
                        <p class="font-medium">{{ $item->name }}</p>
                        <p class="text-xs text-slate-500">Satuan: {{ $item->unit }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('shop.cart.update', $item->id) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="qty" min="1" value="{{ $item->qty }}" class="w-20 rounded-lg border border-slate-300 px-2 py-1 text-sm">
                            <button class="rounded-lg bg-violet-700 text-white px-3 py-1.5 text-xs font-semibold">Update</button>
                        </form>

                        <form method="POST" action="{{ route('shop.cart.remove', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg bg-rose-600 text-white px-3 py-1.5 text-xs font-semibold">Hapus</button>
                        </form>

                        <p class="font-semibold min-w-28 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="p-4 text-slate-500">
                    Keranjang masih kosong.
                    <a href="{{ route('home') }}" class="text-violet-600 font-semibold hover:underline">Mulai belanja</a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-4 h-fit border border-slate-100">
        <h3 class="font-semibold mb-3">Ringkasan Belanja</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span>Ongkir</span><span>Rp {{ number_format($shipping, 0, ',', '.') }}</span></div>
            <div class="border-t pt-2 flex justify-between font-semibold"><span>Total</span><span>Rp {{ number_format($subtotal + $shipping, 0, ',', '.') }}</span></div>
        </div>

        <form method="POST" action="{{ route('shop.checkout.whatsapp') }}" class="mt-4 space-y-2">
            @csrf
            <input
                type="text"
                name="customer_name"
                placeholder="Nama penerima"
                class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                required
            >
            <textarea
                name="address"
                placeholder="Alamat pengantaran"
                rows="2"
                class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
                required
            ></textarea>
            <textarea
                name="notes"
                placeholder="Catatan (opsional)"
                rows="2"
                class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm"
            ></textarea>

            <button class="w-full bg-gradient-to-r from-violet-700 to-purple-600 text-white rounded-xl py-2.5 font-medium hover:opacity-95">
                Checkout via WhatsApp
            </button>
        </form>
        <p class="text-xs text-slate-500 mt-2">Pesanan akan diarahkan ke WhatsApp admin: 087776945300</p>
    </div>
</div>
@endsection

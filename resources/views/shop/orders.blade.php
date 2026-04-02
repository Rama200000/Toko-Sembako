@extends('layouts.app')

@section('content')
<div class="bg-white rounded-2xl shadow-soft overflow-hidden border border-slate-100">
    <div class="px-4 py-3 border-b font-semibold bg-slate-50">Pesanan Saya</div>
    <div class="divide-y">
        @forelse($orders as $order)
            <div class="p-4 hover:bg-slate-50/60 transition">
                <div class="flex justify-between items-center mb-2">
                    <div>
                        <p class="font-semibold">{{ $order->invoice_number }}</p>
                        <p class="text-xs text-slate-500">{{ $order->sold_at?->format('d/m/Y H:i') }}</p>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-violet-100 text-violet-700 font-medium">Selesai</span>
                </div>
                <ul class="list-disc pl-5 text-sm text-slate-600">
                    @foreach($order->items as $item)
                        <li>{{ $item->product_name }} x {{ $item->qty }}</li>
                    @endforeach
                </ul>
                <p class="text-right font-semibold mt-2">Total: Rp {{ number_format($order->grand_total, 0, ',', '.') }}</p>
            </div>
        @empty
            <div class="p-4 text-slate-500">Belum ada pesanan.</div>
        @endforelse
    </div>
</div>
@endsection

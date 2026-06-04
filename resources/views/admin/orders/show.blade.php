@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1fr_0.8fr]">
        <div class="bookletto-card p-6">
            <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Order #{{ $order->id }}</p>
            <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">{{ $order->customer_name }}</h1>
            <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">{{ $order->customer_email }} · {{ $order->customer_phone }}</p>
            <p class="mt-6 text-[color:var(--bookletto-text-mid)]">{{ $order->shipping_address }}</p>

            <div class="mt-8 space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between gap-4 border-b border-[color:var(--bookletto-border)] pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <p class="font-semibold text-[color:var(--bookletto-navy)]">{{ $item->book->title }}</p>
                            <p class="text-sm text-[color:var(--bookletto-text-mid)]">Qty {{ $item->quantity }}</p>
                        </div>
                        <p class="font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($item->total, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bookletto-card h-fit p-6">
            <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Status</p>
            <form action="{{ route('admin.orders.update', $order) }}" method="post" class="mt-4 space-y-4">
                @csrf
                @method('put')
                <select name="status" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3">
                    @foreach (['pending','paid','processing','shipped','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button class="bookletto-button-primary w-full">Perbarui Status</button>
            </form>

            <div class="mt-6 space-y-3 text-sm text-[color:var(--bookletto-text-mid)]">
                <div class="flex items-center justify-between"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex items-center justify-between"><span>Pengiriman</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
                <div class="flex items-center justify-between border-t border-[color:var(--bookletto-border)] pt-3 text-lg font-semibold text-[color:var(--bookletto-navy)]"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.site')

@section('content')
    <section class="bookletto-shell py-12 lg:py-20">
        <div class="bookletto-panel bg-white p-8">
            <p class="bookletto-section-label">Order sukses</p>
            <h1 class="mt-3 text-5xl text-[color:var(--bookletto-navy)]">Pesanan {{ $order->id }} Tersimpan</h1>
            <p class="mt-4 max-w-2xl text-lg text-[color:var(--bookletto-text-mid)]">Terima kasih, {{ $order->customer_name }}. Pesanan Anda sudah dicatat dengan status {{ $order->status }}.</p>

            <div class="mt-8 grid gap-4 md:grid-cols-3">
                <div class="bookletto-card p-5"><p class="text-sm text-[color:var(--bookletto-text-light)]">Subtotal</p><p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p></div>
                <div class="bookletto-card p-5"><p class="text-sm text-[color:var(--bookletto-text-light)]">Pengiriman</p><p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</p></div>
                <div class="bookletto-card p-5"><p class="text-sm text-[color:var(--bookletto-text-light)]">Total</p><p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-gold)]">Rp {{ number_format($order->total, 0, ',', '.') }}</p></div>
            </div>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('home') }}" class="bookletto-button-primary">Kembali ke Home</a>
                <a href="{{ route('cart.index') }}" class="bookletto-button-secondary">Lihat Keranjang</a>
            </div>
        </div>
    </section>
@endsection
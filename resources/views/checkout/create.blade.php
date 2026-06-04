@extends('layouts.site')

@section('content')
    <section class="bookletto-shell py-12 lg:py-20">
        <p class="bookletto-section-label">Checkout</p>
        <h1 class="mt-3 text-5xl text-[color:var(--bookletto-navy)]">Sederhana, Aman, dan Cepat</h1>

        <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_0.8fr]">
            <form action="{{ route('checkout.store') }}" method="post" class="bookletto-card space-y-5 p-6">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nama Penerima</label>
                        <input name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nomor Telepon</label>
                        <input name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Email</label>
                    <input name="customer_email" type="email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Alamat Kirim</label>
                    <textarea name="shipping_address" rows="5" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>{{ old('shipping_address') }}</textarea>
                </div>
                <button class="bookletto-button-primary w-full py-4">Buat Pesanan</button>
            </form>

            <div class="bookletto-card h-fit p-6">
                <p class="bookletto-section-label">Ringkasan</p>
                <div class="mt-5 space-y-4">
                    @foreach ($items as $item)
                        <div class="flex items-start justify-between gap-4 border-b border-[color:var(--bookletto-border)] pb-4 last:border-b-0 last:pb-0">
                            <div>
                                <p class="font-semibold text-[color:var(--bookletto-navy)]">{{ $item['book']->title }}</p>
                                <p class="text-sm text-[color:var(--bookletto-text-mid)]">Qty {{ $item['quantity'] }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-text-light)]">{{ $item['book']->publisher }} · {{ $item['book']->published_year }}</p>
                            </div>
                            <p class="text-sm font-medium text-[color:var(--bookletto-navy)]">Rp {{ number_format($item['total'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-6 border-t border-[color:var(--bookletto-border)] pt-4 text-sm text-[color:var(--bookletto-text-mid)]">
                    <div class="flex items-center justify-between"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    @if(!empty($appliedPromo) && $discountAmount > 0)
                        <div class="mt-2 flex items-center justify-between"><span>Diskon</span><span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span></div>
                    @endif
                    <div class="mt-2 flex items-center justify-between"><span>Pengiriman</span><span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span></div>
                    <div class="mt-4 flex items-center justify-between text-lg font-semibold text-[color:var(--bookletto-navy)]"><span>Total</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                </div>
            </div>
        </div>
    </section>
@endsection
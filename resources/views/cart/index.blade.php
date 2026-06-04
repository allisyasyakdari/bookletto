@extends('layouts.site')

@section('content')
    <section class="bookletto-shell py-12 lg:py-20">
        <p class="bookletto-section-label">Keranjang</p>
        <h1 class="mt-3 text-5xl text-[color:var(--bookletto-navy)]">Pilihan Buku</h1>

        <div class="mt-10 grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="space-y-4">
                @forelse ($items as $item)
                    <div class="bookletto-card flex gap-4 p-4">
                        <div class="bookletto-book-cover relative {{ $item['book']->cover_gradient }} h-52 w-36 shrink-0">
                            @php
                                $coverUrl = $item['book']->cover_image ? \Illuminate\Support\Facades\Storage::url($item['book']->cover_image) : asset('storage/book-covers/sample.svg');
                            @endphp
                            <img src="{{ $coverUrl }}" alt="{{ $item['book']->title }}" class="absolute inset-0 h-full w-full object-cover">
                            
                            <span class="bookletto-book-spine"></span>
                        </div>
                        <div class="flex min-w-0 flex-1 flex-col justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-[color:var(--bookletto-gold)]">{{ $item['book']->category->name }}</p>
                                <h2 class="mt-2 font-display text-2xl text-[color:var(--bookletto-navy)]">{{ $item['book']->title }}</h2>
                                <p class="text-sm text-[color:var(--bookletto-text-mid)]">{{ $item['book']->author }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-text-light)]">{{ $item['book']->publisher }} · {{ $item['book']->published_year }}</p>
                            </div>
                            <div class="flex items-center justify-between gap-4">
                                <form action="{{ route('cart.update', $item['book']) }}" method="post" class="flex items-center gap-2">
                                    @csrf
                                    @method('patch')
                                    <input type="number" min="1" max="99" name="quantity" value="{{ $item['quantity'] }}" class="w-20 rounded-2xl border border-[color:var(--bookletto-border)] px-3 py-2">
                                    <button class="bookletto-button-secondary px-4 py-2">Update</button>
                                </form>
                                <form action="{{ route('cart.remove', $item['book']) }}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="text-sm font-semibold text-red-600">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bookletto-card p-8 text-center text-[color:var(--bookletto-text-mid)]">Keranjang masih kosong. Kembali untuk mulai memilih buku.</div>
                @endforelse
            </div>

            <div class="bookletto-card h-fit p-6">
                <p class="bookletto-section-label">Total</p>
                <form action="{{ route('cart.apply_promo') }}" method="post" class="mt-3 flex gap-2">
                    @csrf
                    <input name="code" placeholder="Kode promo" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] px-3 py-2 text-sm">
                    <button class="rounded-2xl bg-[color:var(--bookletto-gold)] px-4 py-2 font-semibold">Terapkan</button>
                </form>

                @if($appliedPromo)
                    <div class="mt-3 rounded-lg border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-3 text-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-semibold">{{ $appliedPromo->title }} ({{ $appliedPromo->code }})</div>
                                <div class="text-xs text-[color:var(--bookletto-text-mid)]">
                                    @if(($appliedPromo->discount_type ?? 'percent') === 'fixed')
                                        Diskon Rp {{ number_format($appliedPromo->discount_amount ?? 0, 0, ',', '.') }}
                                    @else
                                        Diskon {{ $appliedPromo->discount }}%
                                    @endif
                                    @if($appliedPromo->min_purchase)
                                        · Min Rp {{ number_format($appliedPromo->min_purchase,0,',','.') }}
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('cart.remove_promo') }}" method="post">
                                @csrf
                                <button class="text-sm text-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endif
                <div class="mt-4 flex items-center justify-between text-sm text-[color:var(--bookletto-text-mid)]"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="mt-2 flex items-center justify-between text-sm text-[color:var(--bookletto-text-mid)]"><span>Pengiriman</span><span>Gratis</span></div>
                @if($discountAmount > 0)
                    <div class="mt-3 flex items-center justify-between text-sm text-[color:var(--bookletto-text-mid)]"><span>Diskon</span><span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span></div>
                @endif

                <div class="mt-4 border-t border-[color:var(--bookletto-border)] pt-4 flex items-center justify-between text-xl font-semibold text-[color:var(--bookletto-navy)]"><span>Total</span><span>Rp {{ number_format($totalAfterDiscount, 0, ',', '.') }}</span></div>
                <a href="{{ route('checkout.create') }}" class="bookletto-button-primary mt-6 w-full">Lanjut Checkout</a>
            </div>
        </div>
    </section>
@endsection
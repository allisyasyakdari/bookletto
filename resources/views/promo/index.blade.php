@extends('layouts.site')

@section('content')
<div class="bookletto-shell py-8 lg:py-12 bookletto-promo-root">
    <!-- Header Section -->
    <section class="bookletto-promo-hero mb-8">
        <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-[color:var(--bookletto-gold)]/15 blur-3xl"></div>
        <div class="absolute left-10 top-10 h-32 w-32 rounded-full bg-white/10 blur-3xl"></div>
        <div class="relative">
            <p class="bookletto-section-label text-[color:var(--bookletto-gold-light)]">Penawaran Spesial</p>
            <h1 class="mt-3 font-display text-4xl leading-tight sm:text-5xl">Promo & Kode Diskon</h1>
            <p class="mt-4 max-w-2xl text-base leading-7 text-white/70 sm:text-lg">Dapatkan diskon menarik untuk pembelian buku favorit. Kode promo bisa langsung digunakan saat checkout.</p>
        </div>
    </section>

    <!-- Promo Grid -->
    <div class="bookletto-promo-grid">
        @forelse($promos as $promo)
            <div class="bookletto-promo-card">
                <div class="bookletto-promo-header">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-white/70">{{ $promo->category ?? 'Umum' }}</p>
                            <h2 class="mt-2 font-display text-2xl">{{ $promo->title ?? 'Promo' }}</h2>
                            <p class="mt-2 text-sm text-white/70">{{ Str::limit($promo->subtitle ?? '', 80) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs uppercase tracking-widest text-white/70">Diskon</p>
                            <p class="mt-1 bookletto-promo-discount">
                                @if(($promo->discount_type ?? 'percent') === 'fixed')
                                    Rp {{ number_format($promo->discount_amount ?? 0, 0, ',', '.') }}
                                @else
                                    {{ $promo->discount ?? '0' }}%
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-sm text-slate-300 leading-relaxed mb-4">{{ $promo->description ?? 'Penawaran terbatas untuk pelanggan setia.' }}</p>

                    <div class="promo-code-box mb-4">
                        <code class="font-mono text-lg font-bold text-white">{{ $promo->code ?? 'PROMO2025' }}</code>
                        <button type="button" data-code="{{ $promo->code ?? 'PROMO2025' }}" class="rounded-lg bg-[color:var(--bookletto-navy)] px-3 py-2 text-xs font-semibold text-[color:var(--bookletto-gold)] transition hover:opacity-95" onclick="navigator.clipboard.writeText(this.dataset.code)">Salin Kode</button>
                    </div>

                    <div class="space-y-2 border-t border-white/6 pt-4 text-xs text-slate-300">
                        <div class="flex justify-between">
                            <span>Berlaku Hingga:</span>
                            <span class="font-semibold text-white">{{ $promo->expired_at ? $promo->expired_at->format('d M Y') : 'Unlimited' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Min. Pembelian:</span>
                            <span class="font-semibold text-white">Rp {{ number_format($promo->min_purchase ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status:</span>
                            @if(!$promo->expired_at || $promo->expired_at->isFuture())
                                <span class="font-semibold text-emerald-300">Aktif</span>
                            @else
                                <span class="font-semibold text-rose-300">Berakhir</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full promo-empty">
                <svg class="mx-auto h-16 w-16 text-[color:var(--bookletto-text-light)] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-[color:var(--bookletto-navy)] mb-2">Belum Ada Promo</h3>
                <p class="text-[color:var(--bookletto-text-light)] max-w-md mx-auto">Kami sedang menyiapkan penawaran spesial untuk Anda. Tunggu update terbaru atau cek kembali segera!</p>
            </div>
        @endforelse
    </div>

    <!-- Info Section -->
    @if($promos->isEmpty())
    <section class="mt-12 rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-8">
        <div class="grid gap-8 md:grid-cols-3">
            <div class="text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[color:var(--bookletto-gold)] text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2 1m2-1l-2-1m2 1v2.5"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[color:var(--bookletto-navy)]">Diskon Menarik</h3>
                <p class="mt-2 text-sm text-[color:var(--bookletto-text-light)]">Dapatkan potongan harga hingga 50% untuk pembelian tertentu</p>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[color:var(--bookletto-gold)] text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[color:var(--bookletto-navy)]">Waktu Terbatas</h3>
                <p class="mt-2 text-sm text-[color:var(--bookletto-text-light)]">Promo berlaku untuk periode tertentu, jangan sampai ketinggalan</p>
            </div>
            <div class="text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[color:var(--bookletto-gold)] text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-[color:var(--bookletto-navy)]">Mudah Digunakan</h3>
                <p class="mt-2 text-sm text-[color:var(--bookletto-text-light)]">Cukup masukkan kode saat checkout dan nikmati diskon Anda</p>
            </div>
        </div>
    </section>
    @endif
</div>
@endsection

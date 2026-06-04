@extends('layouts.site')

@section('content')
<div class="bookletto-orders-page min-h-[calc(100vh-200px)]" style="background: #081A2A;">
    <div class="bookletto-shell py-8 lg:py-12">
        <div class="mb-8 lg:mb-10">
            <p class="inline-flex rounded-full border border-white/10 bg-white/6 px-4 py-2 text-[11px] font-semibold uppercase tracking-[0.28em] text-[#CBD5E1] shadow-[0_10px_30px_rgba(0,0,0,0.18)]">Aktif</p>
            <h1 class="mt-2 font-display text-4xl font-semibold tracking-tight text-white lg:text-5xl">
                Pesanan <span class="italic text-amber-300">saya</span>
            </h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-[#CBD5E1] lg:text-base">
                Ringkasan status pesanan dibuat dengan kontras tinggi supaya tetap terbaca saat tema terang aktif.
            </p>
        </div>

        @if($orders->isEmpty())
            <div class="bookletto-orders-panel border border-white/10 bg-[#10283D] p-8 text-center shadow-[0_18px_48px_rgba(0,0,0,0.22)] lg:p-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/6 text-[#D4AF37]">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M8 3v10m8 0V3" />
                    </svg>
                </div>
                <h3 class="mt-5 text-2xl font-semibold text-white">Belum ada pesanan</h3>
                <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-[#CBD5E1]">
                    Mulai berbelanja agar riwayat pesananmu muncul di sini.
                </p>
                <a href="{{ route('dashboard') }}" class="bookletto-button-primary mt-6 inline-flex">
                    Mulai Belanja
                </a>
            </div>
        @else
            @php
                $statusConfig = [
                    'processing' => [
                        'label' => 'Sedang Diproses',
                        'badge' => 'border-orange-300/40 bg-orange-400/10 text-orange-200 shadow-[0_10px_24px_rgba(0,0,0,0.18)]',
                        'accent' => 'bg-orange-400',
                        'icon' => '⏱️',
                        'tone' => 'border-orange-400/30',
                    ],
                    'shipped' => [
                        'label' => 'Sedang Dikirim',
                        'badge' => 'border-amber-300/40 bg-amber-300/10 text-amber-200 shadow-[0_10px_24px_rgba(0,0,0,0.18)]',
                        'accent' => 'bg-amber-300',
                        'icon' => '🚚',
                        'tone' => 'border-amber-300/30',
                    ],
                    'completed' => [
                        'label' => 'Selesai',
                        'badge' => 'border-emerald-300/40 bg-emerald-400/10 text-emerald-200 shadow-[0_10px_24px_rgba(0,0,0,0.18)]',
                        'accent' => 'bg-emerald-400',
                        'icon' => '✅',
                        'tone' => 'border-emerald-400/30',
                    ],
                    'cancelled' => [
                        'label' => 'Dibatalkan',
                        'badge' => 'border-rose-300/40 bg-rose-400/10 text-rose-200 shadow-[0_10px_24px_rgba(0,0,0,0.18)]',
                        'accent' => 'bg-rose-400',
                        'icon' => '✕',
                        'tone' => 'border-rose-400/30',
                    ],
                ];
            @endphp

            <div class="grid gap-4 lg:grid-cols-3">
                <div class="bookletto-orders-stat {{ $statusConfig['processing']['tone'] }} bg-[#10283D] border-white/10 shadow-[0_14px_36px_rgba(0,0,0,0.22)]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/6 text-2xl text-[#D4AF37] ring-1 ring-inset ring-white/10">{{ $statusConfig['processing']['icon'] }}</div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'processing')->count() }}</div>
                            <div class="mt-1 text-sm text-[#CBD5E1]">Sedang Diproses</div>
                        </div>
                    </div>
                </div>
                <div class="bookletto-orders-stat {{ $statusConfig['shipped']['tone'] }} bg-[#10283D] border-white/10 shadow-[0_14px_36px_rgba(0,0,0,0.22)]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/6 text-2xl text-[#D4AF37] ring-1 ring-inset ring-white/10">{{ $statusConfig['shipped']['icon'] }}</div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'shipped')->count() }}</div>
                            <div class="mt-1 text-sm text-[#CBD5E1]">Sedang Dikirim</div>
                        </div>
                    </div>
                </div>
                <div class="bookletto-orders-stat {{ $statusConfig['completed']['tone'] }} bg-[#10283D] border-white/10 shadow-[0_14px_36px_rgba(0,0,0,0.22)]">
                    <div class="flex items-start gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/6 text-2xl text-[#D4AF37] ring-1 ring-inset ring-white/10">{{ $statusConfig['completed']['icon'] }}</div>
                        <div>
                            <div class="text-3xl font-bold text-white">{{ $orders->where('status', 'completed')->count() }}</div>
                            <div class="mt-1 text-sm text-[#CBD5E1]">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-2 overflow-x-auto pb-2">
                <button class="bookletto-orders-tab bookletto-orders-tab-active whitespace-nowrap">
                    Semua
                </button>
                <button class="bookletto-orders-tab whitespace-nowrap">
                    Diproses
                </button>
                <button class="bookletto-orders-tab whitespace-nowrap">
                    Dikirim
                </button>
                <button class="bookletto-orders-tab whitespace-nowrap">
                    Selesai
                </button>
                <button class="bookletto-orders-tab whitespace-nowrap">
                    Dibatalkan
                </button>
            </div>

            <div class="mt-7 space-y-4">
                @foreach($orders as $order)
                    @php
                        $status = $statusConfig[$order->status] ?? $statusConfig['processing'];
                    @endphp

                    <article class="bookletto-orders-card overflow-hidden bg-[#10283D] border border-white/10 shadow-[0_14px_40px_rgba(0,0,0,0.24)]">
                        <header class="flex flex-col gap-4 border-b border-white/10 px-5 py-4 lg:flex-row lg:items-center lg:justify-between lg:px-6">
                            <div>
                                <p class="font-mono text-xs tracking-[0.28em] text-[#94A3B8]">
                                    #BKL-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                                <p class="mt-2 text-sm font-medium text-[#CBD5E1]">
                                    {{ $order->placed_at?->format('d M Y') ?? $order->created_at->format('d M Y') }} · JNE Reguler
                                </p>
                            </div>

                            <span class="bookletto-orders-badge {{ $status['badge'] }} self-start lg:self-auto">
                                {{ $status['label'] }}
                            </span>
                        </header>

                        <div class="px-5 py-5 lg:px-6">
                            @forelse($order->items as $item)
                                <div class="flex gap-4">
                                    <div class="relative shrink-0">
                                        <div class="absolute -left-4 top-0 bottom-0 w-1.5 rounded-r-full {{ $status['accent'] }}"></div>
                                        <div class="flex h-24 w-16 overflow-hidden rounded-xl border border-white/10 bg-[#081A2A] shadow-[0_14px_30px_rgba(0,0,0,0.2)]">
                                            @if($item->book->cover_image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="bookletto-book-cover {{ $item->book->cover_gradient }} flex h-full w-full items-center justify-center px-1 text-center text-[11px] font-semibold text-white/80">
                                                    {{ $item->book->category->name ?? 'Book' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="line-clamp-2 text-base font-semibold text-[#F8FAFC] lg:text-lg">{{ $item->book->title }}</h4>
                                        <p class="mt-1 text-sm text-[#CBD5E1]">{{ $item->book->author }}</p>
                                        <p class="mt-1 text-xs text-[#94A3B8]">1 buku · Resi: JNE1234567890</p>
                                        <p class="mt-3 text-lg font-semibold text-[#F8FAFC]">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        <a href="{{ route('books.show', $item->book->slug) }}" class="mt-3 inline-flex rounded-full border border-white/10 bg-white/6 px-4 py-2 text-xs font-semibold text-[#CBD5E1] transition hover:border-[#D4AF37]/60 hover:bg-white/10 hover:text-white">Lihat detail</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-[#94A3B8]">Tidak ada item</p>
                            @endforelse
                        </div>

                        <footer class="flex flex-col gap-4 border-t border-white/10 bg-[#10283D] px-5 py-4 lg:flex-row lg:items-center lg:justify-between lg:px-6">
                            <div>
                                <p class="text-xs uppercase tracking-[0.24em] text-[#94A3B8]">Total Pesanan</p>
                                <p class="mt-1 text-2xl font-bold text-[#F8FAFC]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 lg:flex-nowrap">
                                <button class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/6 text-[#CBD5E1] transition hover:border-[#D4AF37]/60 hover:bg-white/10 hover:text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 14l-5-5m5 5l5-5" />
                                    </svg>
                                </button>

                                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                    <button class="bookletto-orders-action border-white/10 bg-white/6 text-[#CBD5E1] hover:border-[#D4AF37]/60 hover:bg-white/10 hover:text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Lacak Paket
                                    </button>
                                @endif

                                @if($order->status === 'shipped')
                                    <button class="bookletto-orders-action border-white/10 bg-white/6 text-[#CBD5E1] shadow-[0_14px_28px_rgba(0,0,0,0.18)] hover:border-[#D4AF37]/60 hover:bg-white/10 hover:text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Konfirmasi Terima
                                    </button>
                                @elseif($order->status === 'completed')
                                    <button class="bookletto-orders-action cursor-not-allowed border-white/10 bg-white/6 text-[#CBD5E1]">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                        </svg>
                                        Selesai
                                    </button>
                                @endif
                            </div>
                        </footer>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

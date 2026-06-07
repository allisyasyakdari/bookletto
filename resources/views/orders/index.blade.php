@extends('layouts.site')

@section('content')
@php
    $statusConfig = [
        'pending' => [
            'label' => 'Menunggu Pembayaran',
            'badge' => 'border-amber-200 bg-amber-50 text-amber-800',
            'accent' => 'bg-amber-500',
            'icon' => '💳',
        ],
        'paid' => [
            'label' => 'Sedang Diproses',
            'badge' => 'border-sky-200 bg-sky-50 text-sky-800',
            'accent' => 'bg-sky-500',
            'icon' => '⏱️',
        ],
        'processing' => [
            'label' => 'Sedang Diproses',
            'badge' => 'border-sky-200 bg-sky-50 text-sky-800',
            'accent' => 'bg-sky-500',
            'icon' => '⏱️',
        ],
        'shipped' => [
            'label' => 'Sedang Dikirim',
            'badge' => 'border-indigo-200 bg-indigo-50 text-indigo-800',
            'accent' => 'bg-indigo-500',
            'icon' => '🚚',
        ],
        'completed' => [
            'label' => 'Selesai',
            'badge' => 'border-emerald-200 bg-emerald-50 text-emerald-800',
            'accent' => 'bg-emerald-500',
            'icon' => '✅',
        ],
        'cancelled' => [
            'label' => 'Dibatalkan',
            'badge' => 'border-rose-200 bg-rose-50 text-rose-800',
            'accent' => 'bg-rose-500',
            'icon' => '✕',
        ],
    ];
@endphp

<section class="bookletto-shell py-12 lg:py-20">
    <div class="rounded-[2rem] border border-[color:var(--bookletto-border)] bg-[linear-gradient(135deg,rgba(240,246,252,0.95)_0%,rgba(226,240,253,0.95)_100%)] p-6 shadow-[0_20px_60px_rgba(6,20,35,0.08)] sm:p-8 lg:p-10">
        
        {{-- Hero Header Section (Navy Gold) --}}
        <div class="relative overflow-hidden rounded-[1.8rem] bg-[linear-gradient(135deg,#0b1f3a_0%,#061423_100%)] p-6 text-white sm:p-8 lg:p-10 shadow-[0_12px_40px_rgba(6,20,35,0.15)] mb-8">
            <div class="absolute right-0 top-0 h-44 w-44 rounded-full bg-[color:var(--bookletto-gold)]/10 blur-3xl"></div>
            <div class="absolute left-10 bottom-0 h-24 w-24 rounded-full bg-blue-500/10 blur-2xl"></div>
            <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[color:var(--bookletto-gold-light)]">Pesanan Saya</p>
                    <h1 class="mt-2 font-display text-3xl font-bold tracking-tight text-white lg:text-4xl">Riwayat Transaksi</h1>
                    <p class="mt-2 text-sm text-white/75 max-w-xl">Lacak status pesanan aktif Anda dan riwayat pembelian di bawah ini.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bookletto-button-primary text-xs py-3 px-5">Kembali Belanja</a>
            </div>
        </div>

        @if($orders->isEmpty())
            {{-- Empty State --}}
            <div class="mt-8 rounded-2xl border border-dashed border-[color:var(--bookletto-border)] bg-white/60 p-12 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white border border-[color:var(--bookletto-border)] text-[color:var(--bookletto-gold)] shadow-sm">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M8 3v10m8 0V3" />
                    </svg>
                </div>
                <h3 class="mt-5 text-xl font-bold text-[color:var(--bookletto-navy)]">Belum ada pesanan</h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-[color:var(--bookletto-text-mid)]">
                    Mulai berbelanja agar riwayat pesananmu muncul di sini.
                </p>
                <a href="{{ route('dashboard') }}" class="bookletto-button-primary mt-6 inline-flex">
                    Mulai Belanja
                </a>
            </div>
        @else
            {{-- Statistics Grid --}}
            <div class="grid gap-4 mt-8 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Pending --}}
                <div class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 border border-amber-200 text-xl text-amber-600">💳</div>
                        <div>
                            <div class="text-2xl font-bold text-[color:var(--bookletto-navy)]">{{ $orders->where('status', 'pending')->count() }}</div>
                            <div class="text-xs text-[color:var(--bookletto-text-mid)] font-semibold">Menunggu Pembayaran</div>
                        </div>
                    </div>
                </div>
                {{-- Processing --}}
                <div class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 border border-sky-200 text-xl text-sky-600">⏱️</div>
                        <div>
                            <div class="text-2xl font-bold text-[color:var(--bookletto-navy)]">{{ $orders->whereIn('status', ['processing', 'paid'])->count() }}</div>
                            <div class="text-xs text-[color:var(--bookletto-text-mid)] font-semibold">Sedang Diproses</div>
                        </div>
                    </div>
                </div>
                {{-- Shipped --}}
                <div class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 border border-indigo-200 text-xl text-indigo-600">🚚</div>
                        <div>
                            <div class="text-2xl font-bold text-[color:var(--bookletto-navy)]">{{ $orders->where('status', 'shipped')->count() }}</div>
                            <div class="text-xs text-[color:var(--bookletto-text-mid)] font-semibold">Sedang Dikirim</div>
                        </div>
                    </div>
                </div>
                {{-- Completed --}}
                <div class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white p-4 shadow-sm transition duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 border border-emerald-200 text-xl text-emerald-600">✅</div>
                        <div>
                            <div class="text-2xl font-bold text-[color:var(--bookletto-navy)]">{{ $orders->where('status', 'completed')->count() }}</div>
                            <div class="text-xs text-[color:var(--bookletto-text-mid)] font-semibold">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Interactive Filter Tabs --}}
            <div class="mt-8 flex gap-2 overflow-x-auto border-b border-[color:var(--bookletto-border)] pb-4">
                <button data-filter="all" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-gold)] bg-[color:var(--bookletto-gold)] text-[color:var(--bookletto-navy)] shadow-sm">
                    Semua
                </button>
                <button data-filter="pending" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
                    Menunggu Pembayaran
                </button>
                <button data-filter="processing" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
                    Diproses
                </button>
                <button data-filter="shipped" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
                    Dikirim
                </button>
                <button data-filter="completed" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
                    Selesai
                </button>
                <button data-filter="cancelled" class="filter-tab whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
                    Dibatalkan
                </button>
            </div>

            {{-- Orders List --}}
            <div class="mt-8 space-y-6">
                @foreach($orders as $order)
                    @php
                        $status = $statusConfig[$order->status] ?? $statusConfig['processing'];
                        // Map both 'paid' and 'processing' to 'processing' class for display/filtering consistency
                        $dataStatus = in_array($order->status, ['paid', 'processing']) ? 'processing' : $order->status;
                    @endphp

                    <article class="order-card-item overflow-hidden bg-white border border-[color:var(--bookletto-border)] rounded-2xl shadow-sm hover:shadow-md transition duration-300" data-status="{{ $dataStatus }}">
                        
                        {{-- Card Header --}}
                        <header class="flex flex-col gap-4 border-b border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)]/20 px-5 py-4 lg:flex-row lg:items-center lg:justify-between lg:px-6">
                            <div>
                                <p class="font-mono text-xs tracking-wider text-[color:var(--bookletto-text-light)]">
                                    #BKL-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-[color:var(--bookletto-navy)]">
                                    {{ $order->placed_at?->format('d M Y') ?? $order->created_at->format('d M Y') }} · <span class="uppercase text-[10px] tracking-wider px-2 py-0.5 rounded bg-[color:var(--bookletto-cream)] border border-[color:var(--bookletto-border)] text-[color:var(--bookletto-text-mid)]">{{ $order->payment_method }}</span>
                                </p>
                            </div>

                            <span class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-bold {{ $status['badge'] }} self-start lg:self-auto shadow-sm">
                                <span class="mr-1.5">{{ $status['icon'] }}</span> {{ $status['label'] }}
                            </span>
                        </header>

                        {{-- Items Section --}}
                        <div class="px-5 py-5 lg:px-6 space-y-4">
                            @forelse($order->items as $item)
                                <div class="flex gap-4 border-b border-[color:var(--bookletto-border)]/30 pb-4 last:border-b-0 last:pb-0">
                                    <div class="relative shrink-0">
                                        <div class="absolute -left-4 top-0 bottom-0 w-1.5 rounded-r-full {{ $status['accent'] }}"></div>
                                        <div class="flex h-24 w-16 overflow-hidden rounded-lg border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] shadow-sm">
                                            @if($item->book->cover_image)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($item->book->cover_image) }}" alt="{{ $item->book->title }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="bookletto-book-cover {{ $item->book->cover_gradient }} flex h-full w-full items-center justify-center px-1 text-center text-[10px] font-semibold text-white/95">
                                                    {{ $item->book->category->name ?? 'Buku' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <h4 class="line-clamp-2 text-base font-semibold text-[color:var(--bookletto-navy)]">{{ $item->book->title }}</h4>
                                        <p class="text-sm text-[color:var(--bookletto-text-mid)]">{{ $item->book->author }}</p>
                                        <p class="mt-1 text-xs text-[color:var(--bookletto-text-light)]">{{ $item->quantity }} buku · Rp {{ number_format($item->price, 0, ',', '.') }} / buku</p>
                                        
                                        @if(!in_array($order->status, ['pending', 'cancelled']))
                                            <p class="mt-2 text-xs text-[color:var(--bookletto-text-light)]">Kurir: JNE Express · Resi: JNE{{ str_pad($order->id, 10, '0', STR_PAD_LEFT) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-[color:var(--bookletto-text-light)]">Tidak ada item</p>
                            @endforelse
                        </div>

                        {{-- Card Footer --}}
                        <footer class="flex flex-col gap-4 border-t border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)]/10 px-5 py-4 lg:flex-row lg:items-center lg:justify-between lg:px-6">
                            <div>
                                <p class="text-[10px] uppercase tracking-wider text-[color:var(--bookletto-text-light)]">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-[color:var(--bookletto-navy)]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                @if($order->status === 'pending')
                                    <a href="{{ route('checkout.success', $order) }}" class="bookletto-button-primary px-4 py-2.5 text-xs">
                                        💳 Bayar Sekarang
                                    </a>
                                @elseif($order->status === 'shipped')
                                    <form action="{{ route('orders.complete', $order) }}" method="post" class="inline">
                                        @csrf
                                        <button type="submit" class="bookletto-button-primary px-4 py-2.5 text-xs shadow-sm">
                                            ✓ Konfirmasi Terima
                                        </button>
                                    </form>
                                @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                                        ✓ Pesanan Selesai
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-rose-700 bg-rose-50 border border-rose-200 px-3 py-1.5 rounded-full">
                                        ✕ Dibatalkan
                                    </span>
                                @endif
                            </div>
                        </footer>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.filter-tab');
        const cards = document.querySelectorAll('.order-card-item');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Reset styling for all tabs
                tabs.forEach(t => {
                    t.classList.remove('border-[color:var(--bookletto-gold)]', 'bg-[color:var(--bookletto-gold)]', 'text-[color:var(--bookletto-navy)]', 'shadow-sm');
                    t.classList.add('border-[color:var(--bookletto-border)]', 'bg-white', 'text-[color:var(--bookletto-navy)]');
                });

                // Apply active styling to selected tab
                tab.classList.remove('border-[color:var(--bookletto-border)]', 'bg-white', 'text-[color:var(--bookletto-navy)]');
                tab.classList.add('border-[color:var(--bookletto-gold)]', 'bg-[color:var(--bookletto-gold)]', 'text-[color:var(--bookletto-navy)]', 'shadow-sm');

                const filter = tab.getAttribute('data-filter');

                cards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-status') === filter) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endpush
@endsection

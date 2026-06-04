@extends('layouts.admin')

@section('content')

    <div class="grid gap-6">
        <!-- Top stats cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
            <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
                <p class="text-xs text-[color:var(--bookletto-text-mid)]">Pendapatan bulan ini</p>
                <p class="mt-2 text-2xl font-semibold">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                <p class="mt-1 text-sm text-green-500">+12.4% dari bulan lalu</p>
            </div>

            <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
                <p class="text-xs text-[color:var(--bookletto-text-mid)]">Pesanan bulan ini</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['orders'] }}</p>
                <p class="mt-1 text-sm text-green-500">+8.1% dari bulan lalu</p>
            </div>

            <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
                <p class="text-xs text-[color:var(--bookletto-text-mid)]">Total pengguna</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['users'] ?? '—' }}</p>
                <p class="mt-1 text-sm text-green-500">+34 pengguna baru</p>
            </div>

            <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
                <p class="text-xs text-[color:var(--bookletto-text-mid)]">Total buku</p>
                <p class="mt-2 text-2xl font-semibold">{{ $stats['books'] }}</p>
                <p class="mt-1 text-sm text-green-500">+24 buku bulan ini</p>
            </div>
        </div>

        <!-- Main grid: trend + side columns -->
        <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="space-y-6">
                <!-- Recent orders (Perlu Tindakan) -->
                <div class="bookletto-card p-6 bg-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-[color:var(--bookletto-text-mid)]">PERLU TINDAKAN</p>
                            <h4 class="mt-1 font-semibold text-[color:var(--bookletto-navy)]">Pesanan terbaru</h4>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-[color:var(--bookletto-gold)]">Lihat semua</a>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="text-[color:var(--bookletto-text-mid)]">
                                <tr>
                                    <th class="px-4 py-3">No. Pesanan</th>
                                    <th class="px-4 py-3">Pembeli</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                    @php
                                        $statusStyles = [
                                            'paid' => 'bg-sky-100 text-sky-700',
                                            'processing' => 'bg-yellow-100 text-yellow-700',
                                            'shipped' => 'bg-sky-100 text-sky-700',
                                            'completed' => 'bg-green-100 text-green-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <tr class="border-t border-[color:var(--bookletto-border)]">
                                        <td class="px-4 py-3">#BKL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-[color:var(--bookletto-navy)]">{{ \Illuminate\Support\Str::limit($order->customer_name, 18) }}</div>
                                            <div class="text-xs text-[color:var(--bookletto-text-light)]">{{ $order->created_at?->format('d M Y H:i') }}</div>
                                        </td>
                                        <td class="px-4 py-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                        <td class="px-4 py-3"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$order->status] ?? 'bg-yellow-100 text-yellow-700' }}">{{ $order->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-4 py-3 text-[color:var(--bookletto-text-mid)]">Belum ada order.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Trend card -->
                <div class="bookletto-card p-6 bg-white">
                    <div class="flex items-start justify-between relative z-10">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-[color:var(--bookletto-text-mid)]">TREN</p>
                            <h3 class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">Penjualan 7 hari terakhir</h3>
                            <p class="mt-1 text-sm text-[color:var(--bookletto-text-mid)]">Rp {{ number_format($stats['revenue_last_7_days'] ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div></div>
                    </div>

                    @php
                        $maxSales = max(1, collect($salesChart)->max('total'));
                    @endphp

                    <div class="mt-6 rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-4 overflow-hidden">
                        <div class="flex">
                                <div class="flex-1 chart-scroll overflow-x-auto" style="cursor:grab; -webkit-overflow-scrolling: touch;">
                                <div class="flex h-72 items-end gap-6 pr-0">
                                    @foreach ($salesChart as $point)
                                @php
                                    $maxBarHeight = 180; // px inside SVG (increased so top isn't clipped)
                                    $barHeight = $point['total'] > 0 && $maxSales > 0 ? (int) round(($point['total'] / $maxSales) * $maxBarHeight) : 0;
                                    $barTop = ($maxBarHeight + 20) - $barHeight; // add bottom padding and top room
                                @endphp
                                <div class="flex min-w-0 flex-none flex-col items-center justify-end gap-2" style="min-width:90px;">
                                    @if($point['total'] > 0)
                                        <div class="text-sm font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($point['total'], 0, ',', '.') }}</div>
                                    @else
                                        <div style="height:18px;"></div>
                                    @endif
                                    <div class="flex w-full items-end justify-center">
                                        <svg viewBox="0 0 48 {{ $maxBarHeight + 32 }}" class="w-12 h-52" aria-hidden="true" style="display:block;">
                                            @if($point['total'] > 0)
                                                <rect x="13" y="{{ $barTop }}" width="22" height="{{ $barHeight }}" rx="8" fill="#f59e0b"></rect>
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-semibold text-[color:var(--bookletto-navy)]">{{ $point['label'] }}</div>
                                        <div class="text-sm text-[color:var(--bookletto-text-mid)]">{{ $point['date'] }}</div>
                                    </div>
                                </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs text-[color:var(--bookletto-text-mid)]">
                            <span>Skala otomatis</span>
                            <span>Max Rp {{ number_format($maxSales, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <aside class="space-y-6">
                <div class="bookletto-card p-5 bg-white">
                    <p class="text-xs text-[color:var(--bookletto-text-mid)]">LIVE</p>
                    <h4 class="mt-1 font-semibold text-[color:var(--bookletto-navy)]">Aktivitas terkini</h4>
                    <div class="mt-4 space-y-3 text-sm text-[color:var(--bookletto-text-mid)]">
                        @forelse ($recentOrders->take(4) as $order)
                            <div class="flex items-start gap-3">
                                <div class="h-2 w-2 rounded-full bg-[color:var(--bookletto-gold)] mt-1"></div>
                                <div>
                                    <div class="text-[color:var(--bookletto-navy)] font-semibold">Pesanan #BKL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    <div class="text-[color:var(--bookletto-text-mid)] text-xs">{{ $order->customer_name }} · {{ $order->status }}</div>
                                </div>
                            </div>
                        @empty
                            <p class="text-[color:var(--bookletto-text-mid)]">Tidak ada aktivitas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bookletto-card p-5 bg-white">
                    <p class="text-xs text-[color:var(--bookletto-text-mid)]">POPULER</p>
                    <h4 class="mt-1 font-semibold text-[color:var(--bookletto-navy)]">Buku terlaris</h4>
                    <div class="mt-4 space-y-2 text-sm text-[color:var(--bookletto-text-mid)]">
                        @isset($popularBooks)
                            @foreach($popularBooks as $i => $book)
                                <div class="flex items-center gap-3">
                                    <div class="rounded w-8 h-10 bg-[color:var(--bookletto-gold-pale)] flex items-center justify-center text-[color:var(--bookletto-navy)] font-semibold">{{ $i+1 }}</div>
                                    <div class="truncate">{{ $book->title }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-[color:var(--bookletto-text-mid)]">Data buku populer belum tersedia.</p>
                        @endisset
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sliders = document.querySelectorAll('.chart-scroll');
    sliders.forEach(slider => {
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('cursor-grabbing');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
            e.preventDefault();
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('cursor-grabbing');
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('cursor-grabbing');
        });
        slider.addEventListener('mousemove', (e) => {
            if(!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5; // scroll-fast
            slider.scrollLeft = scrollLeft - walk;
        });

        // touch
        slider.addEventListener('touchstart', (e) => {
            startX = e.touches[0].pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('touchmove', (e) => {
            const x = e.touches[0].pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5;
            slider.scrollLeft = scrollLeft - walk;
        });
    });
    // Auto-scroll to right (newest on the right). Try multiple times so layout settles.
    function scrollToRight(slider, smooth = true) {
        const left = Math.max(0, slider.scrollWidth - slider.clientWidth);
        try { slider.scrollTo({ left, behavior: smooth ? 'smooth' : 'auto' }); } catch (e) { slider.scrollLeft = left; }
    }

    function ensureScrollRight(slider) {
        for (let i = 0; i < 6; i++) requestAnimationFrame(() => scrollToRight(slider, i > 0));
        setTimeout(() => scrollToRight(slider), 300);
    }

    sliders.forEach(s => {
        if (window.ResizeObserver) {
            const ro = new ResizeObserver(() => ensureScrollRight(s));
            ro.observe(s);
            ro.observe(s.querySelector('.flex') || s);
        }
    });

    sliders.forEach(s => ensureScrollRight(s));
    window.addEventListener('load', () => sliders.forEach(s => ensureScrollRight(s)));
});
</script>
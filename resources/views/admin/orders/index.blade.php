@extends('layouts.admin')

@section('content')
    @php
        $statusStyles = [
            'pending' => 'bg-amber-500/10 text-amber-700 border-amber-200',
            'paid' => 'bg-sky-500/10 text-sky-700 border-sky-200',
            'processing' => 'bg-indigo-500/10 text-indigo-700 border-indigo-200',
            'shipped' => 'bg-cyan-500/10 text-cyan-700 border-cyan-200',
            'completed' => 'bg-emerald-500/10 text-emerald-700 border-emerald-200',
            'cancelled' => 'bg-rose-500/10 text-rose-700 border-rose-200',
        ];

        $statusLabels = [
            'pending' => 'Menunggu proses',
            'paid' => 'Dibayar',
            'processing' => 'Diproses',
            'shipped' => 'Sedang dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $formatShortMoney = function ($value) {
            $amount = (float) $value;

            if ($amount >= 1000000) {
                return 'Rp ' . rtrim(rtrim(number_format($amount / 1000000, 1, ',', '.'), '0'), ',') . 'jt';
            }

            if ($amount >= 1000) {
                return 'Rp ' . number_format($amount / 1000, 0, ',', '.') . 'rb';
            }

            return 'Rp ' . number_format($amount, 0, ',', '.');
        };

        $courierMeta = function ($order) {
            return ['key' => 'lettoekspress', 'name' => 'LettoEkspress', 'service' => 'Reg'];
        };
    @endphp

    <div class="w-full rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)] lg:px-6 lg:py-6">
        <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">TRANSAKSI</p>
        <div class="mt-1 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h1 class="font-display text-3xl text-[color:var(--bookletto-navy)]">Manajemen Pesanan</h1>
                <p class="mt-1 max-w-2xl text-sm text-[color:var(--bookletto-text-light)]">Ringkasan pesanan, status, dan detail item ditampilkan dalam format tabel yang padat supaya cepat dipantau.</p>
            </div>
        </div>
    </div>

    <div class="mt-6 grid w-full gap-4 md:grid-cols-3">
            <div class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-4 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
            <p class="text-sm text-[color:var(--bookletto-text-light)]">Dibayar</p>
            <div class="mt-2 text-4xl font-display text-[color:var(--bookletto-navy)]">{{ (int) ($statusCounts['paid'] ?? 0) }}</div>
        </div>
        <div class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-4 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
            <p class="text-sm text-[color:var(--bookletto-text-light)]">Diproses</p>
            <div class="mt-2 text-4xl font-display text-[color:var(--bookletto-navy)]">{{ (int) ($statusCounts['processing'] ?? 0) }}</div>
        </div>
        <div class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-4 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
            <p class="text-sm text-[color:var(--bookletto-text-light)]">Selesai bulan ini</p>
            <div class="mt-2 text-4xl font-display text-[color:var(--bookletto-navy)]">{{ (int) $completedThisMonth }}</div>
        </div>
    </div>

    <form method="get" action="{{ route('admin.orders.index') }}" class="mt-6 grid w-full gap-3 lg:grid-cols-[1.1fr_0.95fr_auto]">
        <label class="flex items-center gap-3 rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 text-[color:var(--bookletto-navy)] shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
            <span class="text-[color:var(--bookletto-text-light)]">⌕</span>
            <input name="q" value="{{ request('q') }}" placeholder="Cari pesanan, pembeli, atau buku" class="w-full bg-transparent text-sm text-[color:var(--bookletto-navy)] placeholder:text-[color:var(--bookletto-text-light)] focus:outline-none">
        </label>

        <select name="status" class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 text-sm text-[color:var(--bookletto-navy)] shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
            <option value="">Semua Status</option>
            @foreach ($statusLabels as $key => $label)
                <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button class="rounded-2xl border border-[color:var(--bookletto-gold)] bg-[color:var(--bookletto-gold)] px-5 py-3 text-sm font-semibold text-[color:var(--bookletto-navy-deep)]">Terapkan</button>
            <a href="{{ route('admin.orders.index') }}" class="rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-5 py-3 text-sm font-semibold text-[color:var(--bookletto-navy)]">Reset</a>
        </div>
    </form>

    <div class="mt-6 w-full overflow-hidden rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-[color:var(--bookletto-navy)]">
                <thead class="border-b border-[color:var(--bookletto-border)] text-xs uppercase tracking-[0.18em] text-[color:var(--bookletto-text-light)]">
                    <tr>
                        <th class="px-5 py-4 font-semibold">No. Pesanan</th>
                        <th class="px-5 py-4 font-semibold">Pembeli</th>
                        <th class="px-5 py-4 font-semibold">Buku</th>
                        <th class="px-5 py-4 font-semibold">Kurir</th>
                        <th class="px-5 py-4 font-semibold">Total</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        @php
                            $primaryItem = $order->items->first();
                            $itemsCount = $order->items->sum('quantity');
                            $bookTitle = $primaryItem?->book?->title ?? 'Tanpa buku';
                            $buyerInitials = collect(preg_split('/\s+/', trim($order->customer_name)))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->implode('');
                            $courier = $courierMeta($order);
                            $statusClass = $statusStyles[$order->status] ?? 'bg-white/10 text-white/70 border-white/10';
                            $statusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);
                        @endphp

                        <tr class="border-b border-[color:var(--bookletto-border)] last:border-b-0 hover:bg-[color:var(--bookletto-cream)]/60">
                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-[color:var(--bookletto-gold)]">#BKL-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[color:var(--bookletto-navy)] text-xs font-bold text-white">
                                        {{ $buyerInitials ?: 'RK' }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-[color:var(--bookletto-navy)]">{{ $order->customer_name }}</div>
                                        <div class="text-xs text-[color:var(--bookletto-text-light)]">{{ $order->customer_email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-[color:var(--bookletto-navy)]">{{ $bookTitle }}</div>
                                <div class="text-xs text-[color:var(--bookletto-text-light)]">x{{ $itemsCount }}</div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-[color:var(--bookletto-navy)]">{{ $courier['name'] }}</div>
                                <div class="text-xs text-[color:var(--bookletto-text-light)]">{{ $courier['service'] }}</div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-[color:var(--bookletto-gold)]">{{ $formatShortMoney($order->total) }}</div>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </td>

                            <td class="px-5 py-4 align-top">
                                <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-[color:var(--bookletto-gold)] hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-[color:var(--bookletto-text-light)]">Belum ada pesanan yang cocok dengan filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endsection
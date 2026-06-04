@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Marketing</p>
                <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Promo & Voucher</h1>
                <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Kelola kode promo, kupon, dan diskon untuk kampanye penjualan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="bookletto-button-secondary">Import CSV</a>
                <a href="{{ route('admin.promos.create') }}" class="bookletto-button-primary">Buat Promo Baru</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[color:var(--bookletto-gold-pale)] text-xl">🎟️</div>
                <div>
                    <div class="text-xs uppercase tracking-[0.22em] text-[color:var(--bookletto-text-mid)]">Promo aktif</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $promos->count() ?? 0 }}</div>
                </div>
            </div>
        </div>
        <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-sky-50 text-xl">🎫</div>
                <div>
                    <div class="text-xs uppercase tracking-[0.22em] text-[color:var(--bookletto-text-mid)]">Total klaim</div>
                    <div class="mt-1 text-2xl font-semibold">—</div>
                </div>
            </div>
        </div>
        <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl">💸</div>
                <div>
                    <div class="text-xs uppercase tracking-[0.22em] text-[color:var(--bookletto-text-mid)]">Nilai diskon diberikan</div>
                    <div class="mt-1 text-2xl font-semibold">—</div>
                </div>
            </div>
        </div>
        <div class="bookletto-card p-5 bg-white text-[color:var(--bookletto-navy)]">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-50 text-xl">⏳</div>
                <div>
                    <div class="text-xs uppercase tracking-[0.22em] text-[color:var(--bookletto-text-mid)]">Segera berakhir</div>
                    <div class="mt-1 text-2xl font-semibold">—</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bookletto-card bg-white p-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-[color:var(--bookletto-navy)]">
                <thead class="border-b border-[color:var(--bookletto-border)] text-xs uppercase tracking-[0.18em] text-[color:var(--bookletto-text-mid)]">
                    <tr>
                        <th class="px-4 py-3">Nama Promo</th>
                        <th class="px-4 py-3">Kode</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Nilai</th>
                        <th class="px-4 py-3">Klaim</th>
                        <th class="px-4 py-3">Batas</th>
                        <th class="px-4 py-3">Berlaku s.d.</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $promo)
                        <tr class="border-b border-[color:var(--bookletto-border)] last:border-b-0 hover:bg-[color:var(--bookletto-cream)]/60">
                            <td class="px-4 py-4 font-semibold text-[color:var(--bookletto-navy)]">{{ $promo->title }}</td>
                            <td class="px-4 py-4 font-mono text-[color:var(--bookletto-gold)]">{{ $promo->code }}</td>
                            <td class="px-4 py-4"><span class="rounded-full bg-[rgba(10,30,50,0.12)] px-3 py-1 text-xs">{{ $promo->category ?? 'Umum' }}</span></td>
                            <td class="px-4 py-4">
                                @if(($promo->discount_type ?? 'percent') === 'fixed')
                                    Rp {{ number_format($promo->discount_amount ?? 0, 0, ',', '.') }}
                                @elseif($promo->discount)
                                    {{ $promo->discount }}%
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-4">—</td>
                            <td class="px-4 py-4">{{ $promo->min_purchase ? number_format($promo->min_purchase,0,',','.') : '—' }}</td>
                            <td class="px-4 py-4 text-[color:var(--bookletto-text-mid)]">{{ $promo->expired_at ? $promo->expired_at->format('d M Y') : '—' }}</td>
                            <td class="px-4 py-4">@if(!$promo->expired_at || $promo->expired_at->isFuture())<span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>@else<span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Berakhir</span>@endif</td>
                            <td class="px-4 py-4 text-right"><div class="flex justify-end gap-2"><a href="{{ route('admin.promos.edit', $promo) }}" class="bookletto-button-secondary">Edit</a>
                                    <form action="{{ route('admin.promos.destroy', $promo) }}" method="post" onsubmit="return confirm('Hapus promo ini?')">@csrf @method('delete')<button type="submit" class="bookletto-button-primary">Hapus</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td class="px-4 py-6 text-[color:var(--bookletto-text-mid)]" colspan="9">Belum ada promo. <a href="{{ route('admin.promos.create') }}" class="text-[color:var(--bookletto-gold)]">Buat sekarang</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $promos->links() }}</div>
</div>
@endsection

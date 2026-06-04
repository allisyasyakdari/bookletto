@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Marketing</p>
                <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Promo & Voucher</h1>
                <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Kelola kode promo, kupon, dan diskon untuk kampanye penjualan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="bookletto-button-secondary">Import CSV</a>
                <a href="#" class="bookletto-button-primary">Buat Promo Baru</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bookletto-panel p-4">
            <div class="flex items-center gap-4">
                <div class="rounded-lg bg-[rgba(9,22,38,0.6)] p-3">🎟️</div>
                <div>
                    <div class="text-2xl font-display text-white">6</div>
                    <div class="text-sm text-white/60">Promo aktif</div>
                </div>
            </div>
        </div>
        <div class="bookletto-panel p-4">
            <div class="flex items-center gap-4">
                <div class="rounded-lg bg-[rgba(201,166,58,0.12)] p-3">🎫</div>
                <div>
                    <div class="text-2xl font-display text-white">342</div>
                    <div class="text-sm text-white/60">Total klaim</div>
                </div>
            </div>
        </div>
        <div class="bookletto-panel p-4">
            <div class="flex items-center gap-4">
                <div class="rounded-lg bg-[rgba(59,130,246,0.12)] p-3">💸</div>
                <div>
                    <div class="text-2xl font-display text-white">Rp 8,4jt</div>
                    <div class="text-sm text-white/60">Nilai diskon diberikan</div>
                </div>
            </div>
        </div>
        <div class="bookletto-panel p-4">
            <div class="flex items-center gap-4">
                <div class="rounded-lg bg-[rgba(239,68,68,0.12)] p-3">⏳</div>
                <div>
                    <div class="text-2xl font-display text-white">2</div>
                    <div class="text-sm text-white/60">Segera berakhir</div>
                </div>
            </div>
        </div>
    </div>

    <div class="bookletto-card p-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-white/60">
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
                    <tr>
                        <td class="px-4 py-4 text-white font-semibold">Gratis Ongkir</td>
                        <td class="px-4 py-4 font-mono text-[color:var(--bookletto-gold)]">FREEONGKIR</td>
                        <td class="px-4 py-4"><span class="rounded-full bg-[rgba(10,30,50,0.12)] px-3 py-1 text-xs">Ongkir</span></td>
                        <td class="px-4 py-4">Gratis</td>
                        <td class="px-4 py-4">128</td>
                        <td class="px-4 py-4">—</td>
                        <td class="px-4 py-4 text-white/60">17 Mei 2025</td>
                        <td class="px-4 py-4"><span class="rounded-full bg-[rgba(34,197,94,0.12)] px-3 py-1 text-xs">Aktif</span></td>
                        <td class="px-4 py-4 text-right"><div class="flex justify-end gap-2"><a href="#" class="bookletto-button-secondary">Edit</a><button class="bookletto-button-primary">Nonaktifkan</button></div></td>
                    </tr>
                    <!-- More rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

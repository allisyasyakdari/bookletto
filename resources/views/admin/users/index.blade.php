@extends('layouts.admin')

@section('content')
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Pengguna</p>
        <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Manajemen Pengguna</h1>
        <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Lihat nama, email, tanggal bergabung, total pesanan, dan total belanja tiap pengguna.</p>
    </div>

    <div class="bookletto-card mt-6 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-[linear-gradient(180deg,rgba(238,243,248,0.95),rgba(255,255,255,0.95))] text-[color:var(--bookletto-text-mid)]">
                <tr>
                    <th class="px-5 py-4 font-semibold">Nama</th>
                    <th class="px-5 py-4 font-semibold">Email</th>
                    <th class="px-5 py-4 font-semibold">Tanggal Bergabung</th>
                    <th class="px-5 py-4 font-semibold">Total Pesanan</th>
                    <th class="px-5 py-4 font-semibold">Total Belanja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t border-[color:var(--bookletto-border)] odd:bg-white even:bg-[color:var(--bookletto-cream)]/40">
                        <td class="px-5 py-4 font-semibold text-[color:var(--bookletto-navy)]">{{ $user->name }}</td>
                        <td class="px-5 py-4 text-[color:var(--bookletto-text-mid)]">{{ $user->email }}</td>
                        <td class="px-5 py-4 text-[color:var(--bookletto-text-mid)]">{{ $user->created_at?->format('d M Y') ?? '-' }}</td>
                        <td class="px-5 py-4 text-[color:var(--bookletto-text-mid)]">{{ $user->orders_count }}</td>
                        <td class="px-5 py-4 font-semibold text-[color:var(--bookletto-navy)]">
                            Rp {{ number_format((float) ($user->total_belanja ?? 0), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $users->links() }}</div>
@endsection
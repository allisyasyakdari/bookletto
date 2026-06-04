@extends('layouts.admin')

@section('content')
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Ulasan</p>
        <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Halaman Ulasan</h1>
        <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Menu baru untuk menampung data ulasan pelanggan ke depan.</p>
    </div>

    <div class="bookletto-card mt-6 p-8 text-center">
        <p class="text-lg font-semibold text-[color:var(--bookletto-navy)]">Belum ada data ulasan</p>
        <p class="mt-2 text-sm text-[color:var(--bookletto-text-light)]">Halaman ini sudah tersedia sebagai menu baru di sidebar admin.</p>
    </div>
@endsection
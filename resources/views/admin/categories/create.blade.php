@extends('layouts.admin')

@section('content')
    <div class="bookletto-card p-6">
        <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Kategori</p>
        <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Kategori Baru</h1>
        <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Tambahkan kategori baru untuk merapikan katalog buku.</p>
        @include('admin.categories.form', ['category' => null, 'action' => route('admin.categories.store'), 'method' => 'post', 'submitLabel' => 'Simpan Kategori'])
    </div>
@endsection
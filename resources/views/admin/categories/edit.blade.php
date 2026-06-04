@extends('layouts.admin')

@section('content')
    <div class="bookletto-card p-6">
        <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Kategori</p>
        <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">{{ $category->name }}</h1>
        <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Perbarui detail kategori yang sudah ada.</p>
        @include('admin.categories.form', ['category' => $category, 'action' => route('admin.categories.update', $category), 'method' => 'put', 'submitLabel' => 'Perbarui Kategori'])
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="bookletto-card p-6 lg:p-7">
            <p class="bookletto-section-label">Edit Buku</p>
            <h2 class="bookletto-section-title mt-2 text-3xl">{{ $book->title }}</h2>
            <p class="mt-3 max-w-2xl text-sm text-[color:var(--bookletto-text-light)]">Perbarui data buku ini. Kalau cover belum perlu diganti, kosongkan saja field gambar agar file lama tetap dipakai.</p>

            @include('admin.books.form', ['book' => $book, 'categories' => $categories, 'action' => route('admin.books.update', $book), 'method' => 'put', 'submitLabel' => 'Perbarui Buku'])
        </div>

        <div class="bookletto-card overflow-hidden p-6 lg:p-7">
            <p class="bookletto-section-label">Ringkasan Buku</p>
            <h3 class="mt-2 font-display text-2xl text-[color:var(--bookletto-navy)]">{{ $book->title }}</h3>
            <div class="mt-5 space-y-3 text-sm text-[color:var(--bookletto-text-mid)]">
                <div class="flex items-center justify-between rounded-2xl bg-[color:var(--bookletto-cream)] px-4 py-3">
                    <span>Penulis</span>
                    <span class="font-semibold text-[color:var(--bookletto-navy)]">{{ $book->author }}</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-[color:var(--bookletto-cream)] px-4 py-3">
                    <span>Kategori</span>
                    <span class="font-semibold text-[color:var(--bookletto-navy)]">{{ $book->category->name ?? '-' }}</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-[color:var(--bookletto-cream)] px-4 py-3">
                    <span>Harga</span>
                    <span class="font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between rounded-2xl bg-[color:var(--bookletto-cream)] px-4 py-3">
                    <span>Stok</span>
                    <span class="font-semibold text-[color:var(--bookletto-navy)]">{{ $book->stock }} unit</span>
                </div>
            </div>

            <div class="mt-5 overflow-hidden rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white">
                @if (! empty($book->cover_image))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="h-64 w-full object-cover">
                @else
                    <div class="flex h-64 items-center justify-center bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))] text-center text-white">
                        <div>
                            <p class="font-display text-2xl">No cover yet</p>
                            <p class="mt-2 text-sm text-white/75">Upload gambar cover untuk bikin kartu buku lebih hidup.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
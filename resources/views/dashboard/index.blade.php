@extends('layouts.site')

@section('content')
@php
    $heroCount = $recommended->count() + $bestsellers->count() + $latest->count();
    $categoryPills = $categories->take(8);
    $catalogBooks = $bestsellers->take(6)->merge($latest->take(6))->unique('id')->take(12);
    $wishlistedIds = is_countable($wishlist) ? $wishlist->pluck('id')->all() : [];
    $categoryBadgeTones = [
        'bg-sky-100 text-sky-800 border-sky-200',
        'bg-emerald-100 text-emerald-800 border-emerald-200',
        'bg-amber-100 text-amber-900 border-amber-200',
        'bg-rose-100 text-rose-800 border-rose-200',
        'bg-violet-100 text-violet-800 border-violet-200',
        'bg-teal-100 text-teal-800 border-teal-200',
    ];
@endphp

<div class="bookletto-orders-page py-8 lg:py-10">
    <div class="bookletto-shell space-y-8">
        <section class="relative overflow-hidden rounded-[2rem] border border-[color:var(--bookletto-border)] bg-[linear-gradient(135deg,#ffffff,rgba(238,243,248,0.98))] px-6 py-8 text-[color:var(--bookletto-text)] shadow-[0_20px_60px_rgba(6,20,35,0.08)] sm:px-8 lg:px-10">
            <div class="absolute right-0 top-0 h-44 w-44 rounded-full bg-[color:var(--bookletto-gold)]/10 blur-3xl"></div>
            <div class="absolute left-10 top-10 h-24 w-24 rounded-full bg-[color:var(--bookletto-navy)]/6 blur-3xl"></div>
            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="bookletto-section-label text-[color:var(--bookletto-gold-light)]">KATALOG CUSTOMER</p>
                    <h1 class="mt-3 font-display text-4xl leading-tight sm:text-5xl">Temukan buku dengan lebih cepat</h1>
                </div>

                <div class="grid grid-cols-2 gap-3 text-sm lg:min-w-[320px]">
                    <div class="rounded-[1.25rem] border border-[color:var(--bookletto-border)] bg-white p-4 shadow-[0_10px_30px_rgba(6,20,35,0.06)] backdrop-blur">
                        <div class="text-[11px] uppercase tracking-[0.28em] text-[color:var(--bookletto-text-light)]">Buku</div>
                        <div class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">{{ $totalBooksCount }}</div>
                    </div>
                    <div class="rounded-[1.25rem] border border-[color:var(--bookletto-border)] bg-white p-4 shadow-[0_10px_30px_rgba(6,20,35,0.06)] backdrop-blur">
                        <div class="text-[11px] uppercase tracking-[0.28em] text-[color:var(--bookletto-text-light)]">Genre</div>
                        <div class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">{{ $categories->count() }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="katalog" class="rounded-[2rem] border border-white/10 bg-white/96 p-5 shadow-[0_20px_60px_rgba(6,20,35,0.08)] backdrop-blur sm:p-6 lg:p-7">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <h2 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Katalog lengkap</h2>
                    <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">Gunakan pencarian atau pilih genre untuk menyaring buku. </p>
                </div>
                <form method="get" action="{{ route('dashboard') }}" class="w-full lg:max-w-md">
                    <label for="catalog-search" class="sr-only">Cari buku</label>
                    @if($selectedCategory)
                        <input type="hidden" name="category" value="{{ $selectedCategory->slug }}">
                    @endif
                    <div class="flex items-center gap-2 rounded-full border border-[color:var(--bookletto-border)] bg-white px-4 py-2 shadow-sm">
                        <svg class="h-5 w-5 shrink-0 text-[color:var(--bookletto-text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.4a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            id="catalog-search"
                            name="q"
                            type="search"
                            value="{{ $searchTerm ?? '' }}"
                            placeholder="Cari judul, penulis, penerbit..."
                            class="w-full border-0 bg-transparent p-0 text-sm text-[color:var(--bookletto-navy)] placeholder:text-[color:var(--bookletto-text-light)] focus:outline-none focus:ring-0"
                        >
                        <button type="submit" class="rounded-full bg-[color:var(--bookletto-gold)] px-4 py-2 text-sm font-semibold text-[color:var(--bookletto-navy)] transition hover:bg-[color:var(--bookletto-gold-light)]">Cari</button>
                    </div>
                </form>
            </div>

            <div class="mt-6 flex gap-3 overflow-x-auto pb-1 sm:flex-wrap sm:overflow-visible">
                <a href="{{ route('dashboard', $searchTerm !== '' ? ['q' => $searchTerm] : []) }}" class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ ! $selectedCategory ? 'border-[color:var(--bookletto-gold)] bg-[color:var(--bookletto-gold)] text-[color:var(--bookletto-navy)]' : 'border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]' }}">Semua</a>
                @foreach($categoryPills as $category)
                    <a href="{{ route('dashboard', array_filter(['category' => $category->slug, 'q' => $searchTerm !== '' ? $searchTerm : null])) }}" class="whitespace-nowrap rounded-full border px-4 py-2 text-sm font-semibold transition {{ $selectedCategory && $selectedCategory->id === $category->id ? 'border-[color:var(--bookletto-gold)] bg-[color:var(--bookletto-gold)] text-[color:var(--bookletto-navy)]' : 'border-[color:var(--bookletto-border)] bg-white text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]' }}">{{ $category->name }}</a>
                @endforeach
            </div>
        </section>

    <section class="mt-8">
        <div class="mb-4 flex items-end justify-between gap-4">
            <div>
                <h3 class="mt-2 font-display text-3xl text-white">Rekomendasi untukmu</h3>
            </div>
            <a href="{{ route('dashboard') }}" class="hidden rounded-full border border-[color:var(--bookletto-border)] bg-white px-4 py-2 text-sm font-semibold text-[color:var(--bookletto-navy)] sm:inline-flex">Muat ulang</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @forelse($catalogBooks as $book)
                @php
                    $badgeTone = $categoryBadgeTones[$loop->index % count($categoryBadgeTones)];
                @endphp
                <div class="relative group flex h-full flex-col overflow-hidden rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white shadow-[0_14px_40px_rgba(6,20,35,0.06)] transition hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(6,20,35,0.12)]">
                    <a href="{{ route('books.show', $book->slug) }}" class="block">
                        <div class="relative h-64 overflow-hidden bg-[color:var(--bookletto-navy)]">
                            @if($book->cover_image)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                            @else
                                <div class="absolute inset-0 {{ $book->cover_gradient }}"></div>
                                <div class="absolute inset-0 z-10 bg-[linear-gradient(180deg,rgba(4,18,32,0.08),rgba(4,18,32,0.92))]"></div>
                                <div class="absolute bottom-4 left-4 right-16 z-20">
                                    <p class="font-display text-2xl font-semibold leading-tight text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.4)] line-clamp-2">{{ $book->title }}</p>
                                    <p class="mt-1 text-sm text-white/90 drop-shadow-[0_2px_8px_rgba(0,0,0,0.35)]">{{ $book->author }}</p>
                                </div>
                            @endif
                        </div>
                    </a>
                    <div class="absolute right-4 top-4 z-30">
                        @auth
                            <form action="{{ route('wishlist.toggle', $book) }}" method="post">
                                @csrf
                                <button
                                    type="submit"
                                    class="wishlist-heart-button {{ in_array($book->id, $wishlistedIds) ? 'wishlist-heart-button--saved' : 'wishlist-heart-button--idle' }} shadow-[0_8px_24px_rgba(0,0,0,0.18)]"
                                    aria-label="{{ in_array($book->id, $wishlistedIds) ? 'Hapus buku dari simpanan' : 'Simpan buku ini' }}"
                                    title="{{ in_array($book->id, $wishlistedIds) ? 'Hapus buku dari simpanan' : 'Simpan buku ini' }}"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z" fill="{{ in_array($book->id, $wishlistedIds) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <button onclick="openModal('login')" class="wishlist-heart-button wishlist-heart-button--idle shadow-[0_8px_24px_rgba(0,0,0,0.18)]" aria-label="Simpan buku ini" title="Simpan buku ini">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                </svg>
                            </button>
                        @endauth
                    </div>
                    <div class="flex flex-1 flex-col justify-between p-4">
                        <div>
                            <h4 class="font-display text-xl font-bold text-[color:var(--bookletto-navy)] line-clamp-1 mb-1" title="{{ $book->title }}">{{ $book->title }}</h4>
                            <p class="text-xs text-[color:var(--bookletto-text-mid)] mb-3">{{ $book->author }}</p>

                            <div class="flex items-center justify-between gap-3">
                                <span class="rounded-full bg-[color:var(--bookletto-gold-pale)] px-3 py-1 text-xs font-semibold text-[color:var(--bookletto-navy)]">{{ $book->published_year }}</span>
                                <span class="text-sm font-semibold text-[color:var(--bookletto-gold)]">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                            </div>
                            <p class="mt-4 line-clamp-2 text-sm leading-6 text-[color:var(--bookletto-text-mid)]">{{ \Illuminate\Support\Str::limit($book->synopsis, 110) }}</p>
                            <div class="mt-4 flex items-center gap-2">
                                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $badgeTone }}">{{ $book->category->name }}</span>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <a href="{{ route('books.show', $book->slug) }}" class="rounded-full bg-[color:var(--bookletto-cream)] px-3 py-1 text-xs font-semibold text-[color:var(--bookletto-navy)]">Lihat detail</a>
                            <form action="{{ route('cart.add', $book) }}" method="post" class="ml-auto">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[color:var(--bookletto-gold)] px-4 py-2 text-xs font-semibold text-[color:var(--bookletto-navy)] transition hover:bg-[color:var(--bookletto-gold-light)]">
                                    <span class="text-base leading-none">+</span>
                                    Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-[1.5rem] border border-dashed border-[color:var(--bookletto-border)] bg-white p-8 text-center text-[color:var(--bookletto-text-mid)] sm:col-span-2 xl:col-span-3">
                    Belum ada buku untuk genre ini. Coba pilih kategori lain atau buka semua buku.
                </div>
            @endforelse
        </div>
    </section>
    </div>
</div>
@endsection

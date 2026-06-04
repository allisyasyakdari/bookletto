@extends('layouts.site')

@section('content')
    <section class="relative overflow-hidden bg-[color:var(--bookletto-navy-deep)] text-white">
        <div class="bookletto-shell relative grid min-h-[calc(100svh-5rem)] gap-10 py-14 lg:grid-cols-[1.2fr_0.8fr] lg:items-center lg:py-16">
            <div class="relative z-10 max-w-3xl">
                <p class="bookletto-section-label text-[color:var(--bookletto-gold-light)]">Toko buku online terpercaya Indonesia</p>
                <h1 class="mt-5 max-w-2xl text-4xl leading-tight text-white sm:text-5xl md:text-7xl">
                    Temukan <span class="text-[color:var(--bookletto-gold)]">Dunia</span> dalam Setiap Halaman
                </h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-white/75 sm:text-lg sm:leading-8">
                    Ribuan judul buku pilihan tersedia — dari fiksi sastra hingga buku bisnis, sains, dan pengembangan diri. Pengiriman cepat ke seluruh Indonesia.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    @guest
                        <a href="#" onclick="openModal('login'); return false;" class="bookletto-button-primary">Mulai Jelajah</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bookletto-button-primary">Mulai Jelajah</a>
                    @endguest
                </div>
                <div class="mt-10 flex flex-wrap gap-3 text-sm text-white/70">
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2">Pengiriman cepat</span>
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2">Pembayaran aman</span>
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2">Pesan online</span>
                </div>
            </div>

            <div class="relative z-10">
                @if($bestSellers->first())
                    @php($heroBook = $bestSellers->first())
                    <div class="bookletto-panel mx-auto max-w-md bg-white/10 p-4 text-white sm:p-5">
                            <div class="bookletto-book-cover relative aspect-[4/5] overflow-hidden bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))]">
                                @if($heroBook->cover_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($heroBook->cover_image) }}" alt="{{ $heroBook->title }}" class="absolute inset-0 h-full w-full object-cover">
                                @endif
                            <span class="bookletto-book-spine"></span>
                            <div class="absolute inset-0 flex flex-col justify-between p-5 sm:p-6">
                                <div class="text-right text-[0.65rem] uppercase tracking-[0.35em] text-white/75">Best seller</div>
                                <div>
                                    <p class="font-display text-3xl font-semibold sm:text-4xl">{{ $heroBook->title }}</p>
                                    <p class="mt-2 text-sm text-white/75">{{ $heroBook->author }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.3em] text-white/55">{{ $heroBook->publisher }} · {{ $heroBook->published_year }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm text-white/65">{{ $heroBook->category->name }}</p>
                                <p class="font-display text-xl sm:text-2xl">Rp {{ number_format($heroBook->price, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('books.show', $heroBook) }}" class="bookletto-button-primary">Lihat Detail</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="best-seller" class="bookletto-shell flex min-h-[calc(100svh-5rem)] flex-col justify-center py-16 lg:py-16">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="bookletto-section-label">Best seller</p>
                <h2 class="bookletto-section-title mt-3">Pilihan Paling Dicari</h2>
            </div>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($bestSellers as $book)
                <a href="{{ route('books.show', $book) }}" class="bookletto-book-card group block bg-white p-4">
                    <div class="bookletto-book-cover relative h-64 bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))]">
                        @if($book->cover_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                        @endif
                        <span class="bookletto-book-spine"></span>
                        <div class="absolute inset-0 flex flex-col justify-between p-5">
                            <div class="flex items-center justify-between text-xs uppercase tracking-[0.3em] text-white/70">
                                <span>Bookletto</span>
                                <span>Cetak</span>
                            </div>
                            <div>
                                <p class="font-display text-2xl font-semibold leading-tight sm:text-3xl">{{ $book->title }}</p>
                                <p class="mt-1 text-sm text-white/75">{{ $book->author }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.28em] text-white/55">{{ $book->publisher }} · {{ $book->published_year }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <p class="text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-gold)]">{{ $book->category->name }}</p>
                        <h3 class="font-display text-2xl text-[color:var(--bookletto-navy)] group-hover:text-[color:var(--bookletto-gold)]">{{ $book->title }}</h3>
                        <p class="text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-text-light)]">{{ $book->publisher }} · {{ $book->published_year }}</p>
                        <p class="text-sm text-[color:var(--bookletto-text-mid)]">{{ Str::limit($book->synopsis, 110) }}</p>
                        <p class="pt-2 text-lg font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section id="kategori" class="flex min-h-[calc(100svh-5rem)] items-center bg-[color:var(--bookletto-cream-2)] py-16 lg:py-16">
        <div class="bookletto-shell">
            <p class="bookletto-section-label">Kategori</p>
            <h2 class="bookletto-section-title mt-3 max-w-2xl">Jelajahi Genre Favoritmu</h2>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($categories as $category)
                    <article class="bookletto-card p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-display text-2xl text-[color:var(--bookletto-navy)]">{{ $category->name }}</p>
                                <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">{{ $category->description }}</p>
                            </div>
                            <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-[color:var(--bookletto-gold-pale)] text-[color:var(--bookletto-navy)]">
                                {{ strtoupper(substr($category->icon ?? 'B', 0, 1)) }}
                            </span>
                        </div>
                        <div class="mt-6 text-sm font-medium text-[color:var(--bookletto-text-light)]">{{ $category->books_count }} judul tersedia</div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured books moved below recommendations per user request --}}

    <section id="rekomendasi" class="flex min-h-[calc(100svh-5rem)] items-center bg-[color:var(--bookletto-navy)] py-16 text-white lg:py-16">
        <div class="bookletto-shell">
            <p class="bookletto-section-label text-[color:var(--bookletto-gold-light)]">Rekomendasi</p>
            <h2 class="bookletto-section-title mt-3 text-white">Buku yang Mungkin Cocok untuk Anda</h2>
            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($recommendations as $book)
                    <a href="{{ route('books.show', $book) }}" class="rounded-[1.75rem] border border-white/10 bg-white/5 p-4 transition hover:-translate-y-1 hover:bg-white/10">
                        <div class="flex gap-4">
                            <div class="bookletto-book-cover relative h-48 w-32 shrink-0 bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))]">
                                @if($book->cover_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                                @endif
                                <span class="bookletto-book-spine"></span>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-white/60">{{ $book->category->name }}</p>
                                <h3 class="mt-2 font-display text-2xl text-white">{{ $book->title }}</h3>
                                <p class="mt-2 text-sm text-white/70">{{ $book->author }}</p>
                                <p class="mt-1 text-xs uppercase tracking-[0.25em] text-white/55">{{ $book->publisher }} · {{ $book->published_year }}</p>
                                <p class="mt-3 text-sm text-white/65">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Insert Featured books here (after recommendations) --}}
    @if($featuredBooks->isNotEmpty())
        <section class="bookletto-shell flex min-h-[calc(100svh-5rem)] flex-col justify-center py-16 lg:py-16">
            @include('partials.featured-custom')
        </section>
    @endif

    <section id="cta" class="bookletto-shell flex min-h-[calc(100svh-5rem)] flex-col justify-center py-16 lg:py-16">
        <div class="bookletto-panel grid gap-10 bg-[linear-gradient(135deg,#ffffff_0%,#fbf4df_100%)] p-6 sm:p-8 lg:grid-cols-[1.05fr_0.95fr] lg:p-12">
            <div>
                <p class="bookletto-section-label">Mulai sekarang</p>
                <h2 class="bookletto-section-title mt-3">Bergabung dengan Pembeli Buku Bookletto</h2>
                <p class="mt-4 max-w-xl text-lg leading-8 text-[color:var(--bookletto-text-mid)]">Daftar gratis, simpan buku favorit, lalu lanjutkan ke checkout sederhana tanpa langkah yang mengganggu ritme belanja.</p>
                <div class="mt-8 flex flex-wrap gap-4">
                    @guest
                        <a href="#" onclick="openModal('login'); return false;" class="bookletto-button-primary">Mulai Jelajah</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bookletto-button-primary">Mulai Jelajah</a>
                    @endguest
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="bookletto-card p-5">
                    <p class="font-display text-4xl text-[color:var(--bookletto-gold)]">1.000+</p>
                    <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">Pembeli aktif tiap bulan</p>
                </div>
                <div class="bookletto-card p-5">
                    <p class="font-display text-4xl text-[color:var(--bookletto-gold)]">8</p>
                    <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">Genre editorial terkurasi</p>
                </div>
                <div class="bookletto-card p-5">
                    <p class="font-display text-4xl text-[color:var(--bookletto-gold)]">24/7</p>
                    <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">Akses katalog tanpa menunggu</p>
                </div>
                <div class="bookletto-card p-5">
                    <p class="font-display text-4xl text-[color:var(--bookletto-gold)]">0</p>
                    <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">Blank page saat route /</p>
                </div>
            </div>
        </div>
    </section>
@endsection

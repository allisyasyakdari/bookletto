@extends('layouts.site')

@section('content')
    <section class="bookletto-shell py-12 lg:py-20">
        <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
            <div class="bookletto-card bg-white p-5">
                <div class="bookletto-book-cover relative aspect-[4/5] overflow-hidden">
                    @if($book->cover_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                    @else
                        <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))]"></div>
                        <span class="bookletto-book-spine"></span>
                        <div class="absolute inset-0 flex flex-col justify-between p-6 text-white">
                            <div class="text-right text-xs uppercase tracking-[0.35em] text-white/70">Bookletto</div>
                            <div>
                                <p class="font-display text-5xl font-semibold">{{ $book->title }}</p>
                                <p class="mt-2 text-sm text-white/70">{{ $book->author }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div>
                <p class="bookletto-section-label">{{ $book->category->name }}</p>
                <h1 class="mt-3 text-5xl leading-tight text-[color:var(--bookletto-navy)]">{{ $book->title }}</h1>
                <p class="mt-4 text-xl text-[color:var(--bookletto-text-mid)]">{{ $book->author }}</p>
                <div class="mt-6 flex flex-wrap gap-3 text-sm font-medium text-[color:var(--bookletto-text-mid)]">
                    <span class="rounded-full bg-[color:var(--bookletto-gold-pale)] px-4 py-2">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                    <span class="rounded-full bg-white px-4 py-2">{{ $book->pages }} halaman</span>
                </div>
                <div class="mt-4 flex flex-wrap gap-3 text-sm text-[color:var(--bookletto-text-mid)]">
                    <span class="rounded-full bg-white px-4 py-2">Penulis: {{ $book->author }}</span>
                    @if($book->publisher)
                        <span class="rounded-full bg-white px-4 py-2">Penerbit: {{ $book->publisher }}</span>
                    @endif
                    @if($book->published_year)
                        <span class="rounded-full bg-white px-4 py-2">Tahun: {{ $book->published_year }}</span>
                    @endif
                </div>
                <p class="mt-8 max-w-3xl text-lg leading-8 text-[color:var(--bookletto-text-mid)]">{{ $book->synopsis }}</p>

                <div class="mt-8 flex flex-wrap gap-4">
                    @auth
                        <form action="{{ route('cart.add', $book) }}" method="post">
                            @csrf
                            <button class="bookletto-button-primary">Tambah ke Keranjang</button>
                        </form>
                        <form action="{{ route('wishlist.toggle', $book) }}" method="post">
                            @csrf
                            <button
                                type="submit"
                                class="wishlist-heart-button {{ $wishlisted ? 'wishlist-heart-button--saved' : 'wishlist-heart-button--idle' }}"
                                aria-label="{{ $wishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}"
                                title="{{ $wishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}"
                            >
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z" fill="{{ $wishlisted ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                </svg>
                                <span class="sr-only">{{ $wishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}</span>
                            </button>
                        </form>
                        <a href="{{ route('checkout.create') }}" class="bookletto-button-secondary">Checkout</a>
                    @else
                        <button onclick="openModal('login')" class="bookletto-button-primary">Tambah ke Keranjang</button>
                        <button
                            onclick="openModal('login')"
                            class="wishlist-heart-button wishlist-heart-button--idle"
                            aria-label="Simpan ke wishlist"
                            title="Simpan ke wishlist"
                        >
                            <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.53L12 21.35z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                            <span class="sr-only">Simpan ke wishlist</span>
                        </button>
                        <button onclick="openModal('login')" class="bookletto-button-secondary">Checkout</button>
                    @endauth
                </div>
            </div>
        </div>

        <div class="mt-12 rounded-[2rem] border border-[color:var(--bookletto-border)] bg-white p-6 shadow-[0_20px_60px_rgba(6,20,35,0.08)] sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="bookletto-section-label">Ulasan</p>
                    <h2 class="mt-3 font-display text-3xl text-[color:var(--bookletto-navy)]">Bagikan pendapatmu</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[color:var(--bookletto-text-mid)]">Beri rating dan komentar untuk membantu pembaca lain memilih buku.</p>
                </div>
            </div>

            @auth
                <form action="{{ route('books.reviews.store', $book) }}" method="post" class="mt-6 grid gap-4 rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-5 sm:p-6">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-[160px_1fr]">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Rating</label>
                            <select name="rating" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 text-[color:var(--bookletto-navy)]">
                                <option value="5">5 - Sangat bagus</option>
                                <option value="4">4 - Bagus</option>
                                <option value="3">3 - Cukup</option>
                                <option value="2">2 - Kurang</option>
                                <option value="1">1 - Buruk</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Komentar</label>
                            <textarea name="comment" rows="4" required class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 text-[color:var(--bookletto-navy)]" placeholder="Tulis ulasan singkat..."></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bookletto-button-primary">Kirim ulasan</button>
                    </div>
                </form>
            @else
                <div class="mt-6 rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white p-5 text-sm text-[color:var(--bookletto-text-mid)]">
                    Masuk dulu untuk menulis ulasan.
                </div>
            @endauth

            <div class="mt-6 space-y-4">
                @forelse($book->reviews ?? collect() as $review)
                    <article class="rounded-[1.35rem] border border-[color:var(--bookletto-border)] bg-white p-5">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-[color:var(--bookletto-navy)]">{{ $review->user->name }}</p>
                                <p class="text-xs uppercase tracking-[0.24em] text-[color:var(--bookletto-text-light)]">{{ str_repeat('★', $review->rating) }}</p>
                            </div>
                            <p class="text-xs text-[color:var(--bookletto-text-light)]">{{ $review->created_at->format('d M Y') }}</p>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-[color:var(--bookletto-text-mid)]">{{ $review->comment }}</p>
                    </article>
                @empty
                    <div class="rounded-[1.35rem] border border-dashed border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-5 text-sm text-[color:var(--bookletto-text-mid)]">
                        Belum ada ulasan untuk buku ini.
                    </div>
                @endforelse
            </div>
        </div>

        @if ($relatedBooks->isNotEmpty())
            <div class="mt-16">
                <p class="bookletto-section-label">Serupa</p>
                <h2 class="bookletto-section-title mt-3">Buku yang Sejalan</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($relatedBooks as $relatedBook)
                        <div class="relative group flex h-full flex-col overflow-hidden rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white shadow-[0_14px_40px_rgba(6,20,35,0.06)] transition hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(6,20,35,0.12)]">
                            <a href="{{ route('books.show', $relatedBook) }}" class="block">
                                <div class="relative aspect-[4/5] overflow-hidden bg-[color:var(--bookletto-navy)]">
                                    @if($relatedBook->cover_image)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($relatedBook->cover_image) }}" alt="{{ $relatedBook->title }}" class="absolute inset-0 h-full w-full object-cover">
                                    @else
                                        <div class="absolute inset-0 {{ $relatedBook->cover_gradient ?? 'bg-gradient-to-br from-blue-900 to-indigo-950' }}"></div>
                                        <div class="absolute inset-0 z-10 bg-[linear-gradient(180deg,rgba(4,18,32,0.08),rgba(4,18,32,0.92))]"></div>
                                        <div class="absolute bottom-4 left-4 right-4 z-20">
                                            <p class="font-display text-2xl font-semibold leading-tight text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.4)] line-clamp-2">{{ $relatedBook->title }}</p>
                                            <p class="mt-1 text-sm text-white/90 drop-shadow-[0_2px_8px_rgba(0,0,0,0.35)]">{{ $relatedBook->author }}</p>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="flex flex-1 flex-col justify-between p-4">
                                <div>
                                    <h4 class="font-display text-lg font-bold text-[color:var(--bookletto-navy)] line-clamp-1 mb-1" title="{{ $relatedBook->title }}">{{ $relatedBook->title }}</h4>
                                    <p class="text-xs text-[color:var(--bookletto-text-mid)] mb-3">{{ $relatedBook->author }}</p>
                                    
                                    <div class="flex items-center justify-between gap-3">
                                        <span class="rounded-full bg-[color:var(--bookletto-gold-pale)] px-3 py-1 text-xs font-semibold text-[color:var(--bookletto-navy)]">{{ $relatedBook->published_year }}</span>
                                        <span class="text-sm font-semibold text-[color:var(--bookletto-gold)]">Rp {{ number_format($relatedBook->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('books.show', $relatedBook) }}" class="rounded-full bg-[color:var(--bookletto-cream)] px-3 py-1 text-xs font-semibold text-[color:var(--bookletto-navy)] inline-block">Lihat detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
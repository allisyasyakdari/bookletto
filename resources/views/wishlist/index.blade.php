@extends('layouts.site')

@section('content')
    <section class="bookletto-shell py-12 lg:py-20">
        <div class="rounded-[2rem] border border-[color:var(--bookletto-border)] bg-white p-6 shadow-[0_20px_60px_rgba(6,20,35,0.08)] sm:p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="bookletto-section-label">Wishlist</p>
                    <h1 class="mt-3 font-display text-4xl text-[color:var(--bookletto-navy)]">Buku Favorit yang Kamu Simpan</h1>
                    <p class="mt-3 max-w-2xl text-[color:var(--bookletto-text-mid)]">Simpan buku yang ingin kamu baca nanti, lalu buka kembali dari sini kapan saja.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="bookletto-button-secondary">Kembali ke katalog</a>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($books as $book)
                    <div class="group overflow-hidden rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white shadow-[0_14px_40px_rgba(6,20,35,0.06)]">
                        <a href="{{ route('books.show', $book->slug) }}" class="block">
                            <div class="relative aspect-[4/5] overflow-hidden bg-[color:var(--bookletto-navy)]">
                                @if($book->cover_image)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                                @else
                                    <div class="absolute inset-0 {{ $book->cover_gradient }}"></div>
                                @endif
                                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(4,18,32,0.12),rgba(4,18,32,0.84))]"></div>
                                <span class="absolute left-4 top-4 rounded-full border border-white/15 bg-white/92 px-3 py-1 text-[10px] uppercase tracking-[0.3em] text-[color:var(--bookletto-navy)] shadow-sm">Wishlist</span>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <p class="font-display text-2xl font-semibold leading-tight text-white drop-shadow-[0_2px_10px_rgba(0,0,0,0.35)] line-clamp-2">{{ $book->title }}</p>
                                    <p class="mt-1 text-sm text-white/90 drop-shadow-[0_2px_8px_rgba(0,0,0,0.3)]">{{ $book->author }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="flex items-center justify-between gap-3 p-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-text-light)]">{{ $book->category->name }}</p>
                                <p class="mt-1 font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('books.show', $book->slug) }}" class="rounded-full border border-[color:var(--bookletto-border)] px-4 py-2 text-center text-sm font-semibold text-[color:var(--bookletto-navy)] transition hover:border-[color:var(--bookletto-gold)] hover:bg-[color:var(--bookletto-gold-pale)]">Detail</a>
                                <form action="{{ route('wishlist.toggle', $book) }}" method="post">
                                    @csrf
                                    <button class="rounded-full border border-[color:var(--bookletto-border)] px-4 py-2 text-sm font-semibold text-[color:var(--bookletto-navy)] transition hover:border-[color:var(--bookletto-gold)] hover:bg-[color:var(--bookletto-gold-pale)]">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 xl:col-span-3 rounded-[1.5rem] border border-dashed border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] p-10 text-center text-[color:var(--bookletto-text-mid)]">
                        Wishlist kamu masih kosong. Buka halaman detail buku lalu klik tombol simpan ke wishlist.
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
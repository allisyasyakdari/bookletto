@extends('layouts.admin')

@section('content')
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="bookletto-section-label">Konten</p>
                <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Buku</h1>
                <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Cari judul atau penulis, lalu pilih kategori bila perlu.</p>
            </div>
        </div>

        <form action="{{ route('admin.books.index') }}" method="get" class="mt-5 grid gap-3 lg:grid-cols-[1fr_260px_auto]">
            <label class="flex items-center gap-3 rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3">
                <svg class="h-5 w-5 text-[color:var(--bookletto-text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul atau penulis" class="w-full border-0 bg-transparent p-0 text-sm text-[color:var(--bookletto-navy)] placeholder:text-[color:var(--bookletto-text-light)] focus:outline-none focus:ring-0">
            </label>

            <select name="category" class="rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm text-[color:var(--bookletto-navy)] focus:border-[color:var(--bookletto-gold)] focus:outline-none focus:ring-0">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-[color:var(--bookletto-navy)] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[color:var(--bookletto-navy-deep)]">Cari</button>
                @if(request()->filled('q') || request()->filled('category'))
                    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-[color:var(--bookletto-border)] px-5 py-3 text-sm font-semibold text-[color:var(--bookletto-navy)] transition hover:bg-white">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <a href="{{ route('admin.books.create') }}" class="group relative flex h-80 flex-col justify-between overflow-hidden rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-[linear-gradient(180deg,rgba(251,244,223,0.95),rgba(255,255,255,0.98))] p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_24px_70px_rgba(0,31,63,0.14)]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(201,166,58,0.18),transparent_55%)]"></div>
            <div class="relative flex items-center justify-between text-[color:var(--bookletto-text-light)]">
                <span class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Add new</span>
                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold shadow-sm">Manual input</span>
            </div>

            <div class="relative flex flex-1 flex-col items-center justify-center text-center">
                <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-[color:var(--bookletto-gold)] text-white shadow-[0_18px_40px_rgba(201,166,58,0.32)] transition-transform duration-300 group-hover:scale-110">
                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <p class="font-display text-2xl text-[color:var(--bookletto-navy)]">Tambah Buku</p>
                <p class="mt-2 max-w-[14rem] text-sm text-[color:var(--bookletto-text-light)]">Buka form untuk isi buku baru dan upload cover langsung dari sini.</p>
            </div>

            <div class="relative flex items-center justify-between text-xs text-[color:var(--bookletto-text-light)]">
                <span>Siap input cover</span>
                <span class="font-semibold text-[color:var(--bookletto-navy)]">→</span>
            </div>
        </a>

        @forelse ($books as $book)
            <div class="group relative flex h-80 flex-col overflow-hidden rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white shadow-[0_18px_45px_rgba(0,31,63,0.08)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_24px_70px_rgba(0,31,63,0.14)]">
                <a href="{{ route('admin.books.edit', $book) }}" aria-label="Edit {{ $book->title }}" class="absolute inset-0 z-10"></a>

                <div class="relative z-20 pointer-events-none border-b border-[color:var(--bookletto-border)] bg-[linear-gradient(180deg,rgba(238,243,248,0.95),rgba(255,255,255,0.98))] px-4 py-3">
                    <div class="min-h-14">
                        <h3 class="line-clamp-2 text-sm font-semibold text-[color:var(--bookletto-navy)]" title="{{ $book->title }}">{{ $book->title }}</h3>
                        <p class="mt-0.5 line-clamp-1 text-xs text-[color:var(--bookletto-text-light)]">{{ $book->author }}</p>
                    </div>

                    <div class="mt-2 flex flex-wrap gap-1.5">
                        @if($book->is_featured)
                            <span class="inline-flex items-center rounded-full bg-purple-100 px-2 py-0.5 text-xs font-medium text-purple-700">Featured</span>
                        @endif
                        @if($book->is_bestseller)
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-700">Bestseller</span>
                        @endif
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700">{{ $book->category->name }}</span>
                    </div>
                </div>

                <div class="relative z-20 flex-1 overflow-hidden bg-gray-100 pointer-events-none">
                    <div class="bookletto-book-cover relative h-full w-full bg-[linear-gradient(135deg,rgba(6,20,35,0.95),rgba(201,166,58,0.65))]">
                        @if($book->cover_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center text-white/55">
                                <svg class="mb-3 h-12 w-12 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h8l6 6v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 4v6h6" />
                                </svg>
                                <p class="text-xs uppercase tracking-[0.25em]">No cover image</p>
                                <p class="mt-2 text-xs text-white/35">Upload cover biar kartu ini hidup.</p>
                            </div>
                        @endif

                        <div class="absolute inset-x-0 bottom-0 bg-[linear-gradient(180deg,transparent,rgba(6,20,35,0.72))] px-4 py-3">
                            <div class="flex items-end justify-between gap-3 text-white">
                                <div></div>
                                <div class="rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs text-white/85 backdrop-blur">
                                    {{ $book->published_year ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 flex items-center justify-center gap-2 bg-[rgba(6,20,35,0.44)] opacity-0 transition-opacity duration-300 group-hover:opacity-100 pointer-events-none">
                        <a href="{{ route('admin.books.edit', $book) }}" class="pointer-events-auto inline-flex items-center gap-2 rounded-lg bg-[color:var(--bookletto-gold)] px-3 py-2 text-xs font-semibold text-[color:var(--bookletto-navy)] transition-colors hover:bg-[color:var(--bookletto-gold)]/90">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="post" onsubmit="return confirm('Hapus buku ini?')" class="pointer-events-auto inline-block">
                            @csrf
                            @method('delete')
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition-colors hover:bg-red-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                <div class="relative z-20 pointer-events-none border-t border-[color:var(--bookletto-border)] bg-[linear-gradient(180deg,rgba(255,255,255,0.98),rgba(247,250,255,1))] px-4 py-3 text-xs">
                    <div class="mb-1 flex items-center justify-between">
                        <span class="text-[color:var(--bookletto-text-light)]">Harga</span>
                        <span class="font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[color:var(--bookletto-text-light)]">Stock</span>
                        <span class="font-semibold text-[color:var(--bookletto-navy)]">{{ $book->stock }} unit</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full rounded-2xl border-2 border-dashed border-[color:var(--bookletto-border)] bg-white/55 p-8 text-center sm:col-span-2 lg:col-span-3 xl:col-span-4">
                <svg class="mx-auto mb-2 h-12 w-12 text-[color:var(--bookletto-text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <p class="text-[color:var(--bookletto-text-light)]">Belum ada buku. <a href="{{ route('admin.books.create') }}" class="font-semibold text-[color:var(--bookletto-gold)] hover:underline">Tambah buku pertama</a></p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $books->links() }}
    </div>
@endsection
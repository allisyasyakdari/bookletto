<form action="{{ $action }}" method="post" enctype="multipart/form-data" class="mt-6 space-y-8">
    @csrf
    @if ($method !== 'post')
        @method($method)
    @endif

    <section class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)]/70 p-5 shadow-[0_10px_30px_rgba(0,31,63,0.05)]">
        <div class="mb-4">
            <p class="bookletto-section-label text-xs">Identitas Buku</p>
            <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Data inti yang paling sering dibaca pengunjung.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Judul</label>
                <input name="title" value="{{ old('title', $book->title ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="Contoh: Senja di Bawah Kaca" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Penulis</label>
                <input name="author" value="{{ old('author', $book->author ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="Nama penulis" required>
            </div>
        </div>
    </section>

    <section class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white p-5 shadow-[0_10px_30px_rgba(0,31,63,0.05)]">
        <div class="mb-4">
            <p class="bookletto-section-label text-xs">Detail Penerbitan</p>
            <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Isi metadata dasar biar katalog tetap rapi.</p>
        </div>

            <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Penerbit</label>
                <input name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="Nama penerbit">
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Tahun Terbit</label>
                <input name="published_year" type="number" min="1900" max="{{ now()->addYear()->year }}" value="{{ old('published_year', $book->published_year ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="2026">
            </div>
        </div>

        <div class="mt-4 grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Kategori</label>
                <select name="category_id" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </section>

    <section class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)]/70 p-5 shadow-[0_10px_30px_rgba(0,31,63,0.05)]">
        <div class="mb-4">
            <p class="bookletto-section-label text-xs">Harga</p>
            <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Data yang memengaruhi tampilan listing dan checkout.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Harga</label>
                <input name="price" type="number" min="1000" value="{{ old('price', $book->price ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="159000" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Stok</label>
                <input name="stock" type="number" min="0" value="{{ old('stock', $book->stock ?? 0) }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="25" required>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Halaman</label>
                <input name="pages" type="number" min="1" value="{{ old('pages', $book->pages ?? 180) }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="180">
            </div>
        </div>
    </section>

    <section class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-white p-5 shadow-[0_10px_30px_rgba(0,31,63,0.05)]">
        <div class="mb-4">
            <p class="bookletto-section-label text-xs">Cover & Sinopsis</p>
            <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Upload cover, lalu isi sinopsis yang singkat tapi cukup informatif.</p>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Gambar Cover</label>
            <input name="cover_image" type="file" accept="image/*" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 shadow-sm transition file:mr-4 file:rounded-full file:border-0 file:bg-[color:var(--bookletto-gold)] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[color:var(--bookletto-navy)] hover:border-[color:var(--bookletto-gold)]">
            <p class="mt-2 text-xs text-[color:var(--bookletto-text-light)]">Format: JPG, PNG, atau WebP. Saat edit, kalau dibiarkan kosong cover lama tetap dipakai.</p>
            @if (! empty($book->cover_image))
                <div class="mt-3 overflow-hidden rounded-2xl border border-[color:var(--bookletto-border)] bg-white shadow-sm">
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="h-48 w-full object-cover">
                </div>
            @endif
        </div>

        <div class="mt-4">
            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Sinopsis</label>
            <textarea name="synopsis" rows="6" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none" placeholder="Tulis sinopsis singkat yang enak dibaca" required>{{ old('synopsis', $book->synopsis ?? '') }}</textarea>
        </div>
    </section>

    <section class="rounded-[1.5rem] border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)]/70 p-5 shadow-[0_10px_30px_rgba(0,31,63,0.05)]">
        <div class="mb-4">
            <p class="bookletto-section-label text-xs">Flags & Publish Date</p>
            <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Tandai buku unggulan atau bestseller kalau memang perlu tampil lebih menonjol.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <label class="flex items-center gap-3 rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $book->is_featured ?? false))>
                <span class="font-semibold text-[color:var(--bookletto-navy)]">Featured</span>
            </label>
            <label class="flex items-center gap-3 rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm">
                <input type="checkbox" name="is_bestseller" value="1" @checked(old('is_bestseller', $book->is_bestseller ?? false))>
                <span class="font-semibold text-[color:var(--bookletto-navy)]">Bestseller</span>
            </label>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Tanggal Terbit</label>
                <input name="published_at" type="date" value="{{ old('published_at', isset($book?->published_at) ? optional($book->published_at)->format('Y-m-d') : '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-white px-4 py-3 shadow-sm transition focus:border-[color:var(--bookletto-gold)] focus:outline-none">
            </div>
        </div>
    </section>

    <div class="flex flex-wrap items-center gap-3">
        <button class="bookletto-button-primary">{{ $submitLabel }}</button>
        <p class="text-sm text-[color:var(--bookletto-text-light)]">Pastikan cover dan sinopsis sudah sesuai sebelum simpan.</p>
    </div>
</form>
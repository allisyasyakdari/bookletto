<form action="{{ $action }}" method="post" class="mt-6 space-y-5">
    @csrf
    @if ($method !== 'post')
        @method($method)
    @endif

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nama</label>
            <input name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>
        </div>
        <div>
            <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Urutan</label>
            <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" required>
        </div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Icon</label>
        <input name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3" placeholder="book-open">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3">{{ old('description', $category->description ?? '') }}</textarea>
    </div>

    <button class="bookletto-button-primary">{{ $submitLabel }}</button>
</form>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Judul</label>
        <input type="text" name="title" value="{{ old('title', $promo->title ?? '') }}" class="w-full mt-1 p-2 border rounded" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Subjudul</label>
        <input type="text" name="subtitle" value="{{ old('subtitle', $promo->subtitle ?? '') }}" class="w-full mt-1 p-2 border rounded">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium">Deskripsi</label>
        <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded">{{ old('description', $promo->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium">Kode</label>
        <input type="text" name="code" value="{{ old('code', $promo->code ?? '') }}" class="w-full mt-1 p-2 border rounded" required>
    </div>

    <div>
        <label class="block text-sm font-medium">Tipe Diskon</label>
        <select name="discount_type" class="w-full mt-1 p-2 border rounded">
            <option value="percent" @selected(old('discount_type', $promo->discount_type ?? 'percent') === 'percent')>Persen (%)</option>
            <option value="fixed" @selected(old('discount_type', $promo->discount_type ?? 'percent') === 'fixed')>Nominal (Rp)</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium">Nilai Diskon</label>
        <input type="number" name="discount" value="{{ old('discount', $promo->discount ?? 0) }}" class="w-full mt-1 p-2 border rounded" min="0">
        <p class="mt-1 text-xs text-[color:var(--bookletto-text-light)]">Untuk persen isi 0-100, untuk nominal isi dalam rupiah tanpa titik.</p>
    </div>

    <div>
        <label class="block text-sm font-medium">Nominal Diskon (Rp)</label>
        <input type="number" name="discount_amount" value="{{ old('discount_amount', $promo->discount_amount ?? 0) }}" class="w-full mt-1 p-2 border rounded" min="0">
        <p class="mt-1 text-xs text-[color:var(--bookletto-text-light)]">Dipakai jika tipe diskon memilih Nominal (Rp).</p>
    </div>

    <div>
        <label class="block text-sm font-medium">Minimal Pembelian (Rp)</label>
        <input type="number" name="min_purchase" value="{{ old('min_purchase', $promo->min_purchase ?? 0) }}" class="w-full mt-1 p-2 border rounded">
    </div>

    <div>
        <label class="block text-sm font-medium">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $promo->category ?? '') }}" class="w-full mt-1 p-2 border rounded">
    </div>

    <div>
        <label class="block text-sm font-medium">Kadaluarsa</label>
        <input type="date" name="expired_at" value="{{ old('expired_at', isset($promo) && $promo->expired_at ? $promo->expired_at->format('Y-m-d') : '') }}" class="w-full mt-1 p-2 border rounded">
    </div>
</div>

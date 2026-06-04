@extends('layouts.admin')

@section('content')
    <div class="mb-6 rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white px-5 py-5 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.28em] text-[color:var(--bookletto-gold)]">Kategori</p>
                <h1 class="mt-2 font-display text-3xl text-[color:var(--bookletto-navy)]">Daftar Kategori</h1>
                <p class="mt-1 text-sm text-[color:var(--bookletto-text-light)]">Kategori tampil sebagai tabel yang lebih lapang supaya cepat dipindai tanpa terasa kosong.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="bookletto-button-primary">Tambah Kategori</a>
        </div>
    </div>

    <div class="bookletto-card mt-6 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-[linear-gradient(180deg,rgba(238,243,248,0.95),rgba(255,255,255,0.95))] text-[color:var(--bookletto-text-mid)]">
                <tr>
                    <th class="px-5 py-4 font-semibold">Nama</th>
                    <th class="px-5 py-4 font-semibold">Deskripsi</th>
                    <th class="px-5 py-4 font-semibold">Buku</th>
                    <th class="px-5 py-4 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-t border-[color:var(--bookletto-border)] odd:bg-white even:bg-[color:var(--bookletto-cream)]/40">
                        <td class="px-5 py-4 font-semibold text-[color:var(--bookletto-navy)]">{{ $category->name }}</td>
                        <td class="px-5 py-4 text-[color:var(--bookletto-text-mid)]">{{ $category->description }}</td>
                        <td class="px-5 py-4">{{ $category->books_count }}</td>
                        <td class="px-5 py-4">
                            <div class="flex gap-3">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="font-semibold text-[color:var(--bookletto-gold)]">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="post" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('delete')
                                    <button class="font-semibold text-red-600">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
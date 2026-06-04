@extends('layouts.admin')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
        <div class="bookletto-card p-6 lg:p-7">
            <p class="bookletto-section-label">Tambah Buku</p>
            <h2 class="bookletto-section-title mt-2 text-3xl">Buku Baru</h2>
            <p class="mt-3 max-w-2xl text-sm text-[color:var(--bookletto-text-light)]">Isi data buku baru dari sini. Cover image bisa langsung diupload tanpa takut ketimpa oleh seeder lagi.</p>

            @include('admin.books.form', ['book' => null, 'categories' => $categories, 'action' => route('admin.books.store'), 'method' => 'post', 'submitLabel' => 'Simpan Buku'])
        </div>

        
    </div>
@endsection
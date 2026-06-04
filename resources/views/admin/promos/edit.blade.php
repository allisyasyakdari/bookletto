@extends('layouts.admin')

@section('content')
<div class="rounded-[1.75rem] border border-[color:var(--bookletto-border)] bg-white p-6 shadow-[0_18px_45px_rgba(0,31,63,0.06)]">
    <h2 class="mb-4 font-display text-3xl text-[color:var(--bookletto-navy)]">Edit Promo</h2>

    <form action="{{ route('admin.promos.update', $promo) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.promos._form')

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="bookletto-button-primary">Perbarui Promo</button>
            <a href="{{ route('admin.promos.index') }}" class="bookletto-button-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection

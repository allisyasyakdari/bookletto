@extends('layouts.auth')

@section('modal')
    <div class="bookletto-auth-card relative z-10 w-full max-w-[26rem] overflow-hidden bg-white/96 shadow-[0_30px_90px_rgba(0,0,0,0.24)] backdrop-blur-xl">
        <div class="flex items-center justify-between bg-[color:var(--bookletto-navy-deep)] px-6 py-5 text-white">
            <p class="font-display text-3xl leading-none">Book<span class="text-[color:var(--bookletto-gold)]">Letto</span></p>
            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-white transition hover:bg-white/20">×</a>
        </div>

        <div class="bg-white px-5 pb-6 pt-5 sm:px-6">
            <div class="relative flex items-end justify-center border-b border-[color:var(--bookletto-border)] text-center">
                <a href="{{ route('login') }}" class="w-1/2 px-3 pb-4 text-lg font-semibold text-[color:var(--bookletto-text-light)]">Masuk</a>
                <a href="{{ route('register') }}" class="w-1/2 border-b-2 border-[color:var(--bookletto-navy)] px-3 pb-4 text-lg font-semibold text-[color:var(--bookletto-navy)]">Daftar Akun</a>
            </div>

            @if ($errors->any())
                <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('register.store') }}" method="post" class="mt-6 space-y-4">
                @csrf
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nama Depan</label>
                        <input name="name" value="{{ old('name') }}" type="text" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 outline-none transition focus:border-[color:var(--bookletto-gold)]" placeholder="Al" required>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nomor Telepon</label>
                        <input name="phone" value="{{ old('phone') }}" type="text" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 outline-none transition focus:border-[color:var(--bookletto-gold)]" placeholder="08xx-xxxx-xxxx">
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Alamat Email</label>
                    <input name="email" value="{{ old('email') }}" type="email" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 outline-none transition focus:border-[color:var(--bookletto-gold)]" placeholder="contoh@email.com" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Password</label>
                    <input name="password" type="password" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 outline-none transition focus:border-[color:var(--bookletto-gold)]" placeholder="Min. 8 karakter" required>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Konfirmasi Password</label>
                    <input name="password_confirmation" type="password" class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 outline-none transition focus:border-[color:var(--bookletto-gold)]" placeholder="Ulangi password" required>
                </div>
                <button class="bookletto-button-primary w-full py-4 text-base">Buat akun</button>
            </form>

            <p class="mt-5 text-center text-sm text-[color:var(--bookletto-text-light)]">Sudah memiliki akun? <a href="{{ route('login') }}" class="font-semibold text-[color:var(--bookletto-navy)]">Masuk sekarang</a></p>
        </div>
    </div>
@endsection
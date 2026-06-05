<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin - Bookletto' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[color:var(--bookletto-cream)] overflow-x-hidden">
    <div class="flex flex-col min-h-screen lg:flex-row">
        <aside class="bg-[color:var(--bookletto-navy-deep)] text-white w-72 fixed inset-y-0 left-0 flex h-screen flex-col overflow-hidden" style="position:fixed !important;top:0;left:0;bottom:0;width:18rem;z-index:50;">
            <div class="flex h-20 items-center justify-between px-6 lg:justify-start">
                <span class="font-display text-3xl">Book<span class="text-[color:var(--bookletto-gold)]">Letto</span></span>
                <a href="{{ route('home') }}" class="rounded-full border border-white/10 px-3 py-1 text-xs text-white/70 lg:hidden">Site</a>
            </div>
            <div class="flex-1 overflow-y-auto">
                <div class="px-4 pb-2 pt-4 text-xs font-semibold uppercase tracking-[0.25em] text-white/25">Utama</div>
                <nav class="flex gap-2 overflow-x-auto px-4 pb-4 text-sm lg:block lg:space-y-1 lg:overflow-visible lg:px-4 lg:pb-3">
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.books.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.books.index') }}">Buku</a>
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.users.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.users.index') }}">Pengguna</a>
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.orders.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.orders.index') }}">Pesanan</a>
                </nav>

                <div class="px-4 pb-2 pt-4 text-xs font-semibold uppercase tracking-[0.25em] text-white/25">Konten</div>
                <nav class="flex gap-2 overflow-x-auto px-4 pb-4 text-sm lg:block lg:space-y-1 lg:overflow-visible lg:px-4 lg:pb-6">
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.promos.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.promos.index') }}">Promo & Voucher</a>
                    <a class="block whitespace-nowrap rounded-2xl px-4 py-3 transition {{ request()->routeIs('admin.categories.*') ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}" href="{{ route('admin.categories.index') }}">Kategori</a>
                </nav>
            </div>

            <div class="shrink-0 px-4 pb-5 pt-4">
                <form action="{{ route('logout') }}" method="post" onsubmit="return confirm('Apakah anda yakin ingin logout dari sistem?')">
                    @csrf
                    <button type="submit" class="w-full rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-left text-sm font-semibold text-white transition hover:bg-white/10">Logout</button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex flex-1 flex-col lg:ml-72" style="margin-left:18rem;">
            <main class="min-w-0 flex-1 p-4 sm:p-6 lg:p-8">
                @if (session('status'))
                    <div class="bookletto-card mb-6 px-5 py-4">{{ session('status') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

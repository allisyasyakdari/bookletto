<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Bookletto') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">
    <header class="sticky top-0 z-50 border-b border-white/10 bg-[color:rgba(0,23,45,0.92)] text-white backdrop-blur-xl shadow-[0_12px_30px_rgba(0,0,0,0.18)]">
        <div class="bookletto-shell flex min-h-16 flex-col gap-4 py-4 md:min-h-20 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="font-display text-3xl font-semibold text-white">Book<span class="text-[color:var(--bookletto-gold)]">Letto</span></span>
                </a>

                @guest
                    {{-- single Masuk button (visible on all sizes) --}}
                @endguest
            </div>

            @auth
                @if (! auth()->user()->is_admin)
                    <nav class="order-3 flex items-center gap-2 overflow-x-auto pb-1 text-sm md:order-none md:gap-3 md:pb-0">
                        <a href="{{ route('dashboard') }}" class="bookletto-nav-pill hidden sm:inline-flex">Katalog</a>
                        <a href="{{ route('wishlist.index') }}" class="bookletto-nav-pill hidden sm:inline-flex">Wishlist</a>
                        <a href="{{ route('promo') }}" class="bookletto-nav-pill hidden sm:inline-flex">Promo</a>
                        <a href="{{ route('orders') }}" class="bookletto-nav-pill hidden sm:inline-flex">Pesanan Saya</a>
                    </nav>
                @endif
            @endauth

            <div class="flex items-center gap-3">
                @auth
                    @if (auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="bookletto-button-secondary hidden sm:inline-flex">Dashboard</a>
                    @else
                        <a href="{{ route('cart.index') }}" class="icon-button" aria-label="Keranjang">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4"/></svg>
                            @if(session('cart') && count(session('cart')))
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full text-xs px-1">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="bookletto-button-primary">Keluar</button>
                    </form>
                @else
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1">
        @if (session('status'))
            <div class="bookletto-shell pt-6">
                <div class="bookletto-card px-5 py-4 text-sm font-medium text-[color:var(--bookletto-navy)]">
                    {{ session('status') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-white/10 bg-[color:var(--bookletto-navy-deep)] text-white">
        <div class="bookletto-shell py-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="font-display text-2xl">Bookletto</p>
                    <p class="mt-2 max-w-xl text-sm text-white/70">Katalog buku fisik dengan nuansa navy-gold yang premium, tenang, dan siap dipesan online.</p>
                </div>
                <div class="text-sm text-white/60">Laravel 12 · Blade · Tailwind · Vite · PostgreSQL</div>
            </div>
        </div>
    </footer>
    
    {{-- Modal overlay for auth (login/register) --}}
    <div id="modal" class="overlay" onclick="handleOv(event)">
        <div class="mcard" onclick="event.stopPropagation()">
            @include('partials.modal-login')
            @include('partials.modal-register')
        </div>
    </div>
    
    <script>
        // small fallback if module JS not loaded yet
        function openModal(tab){
            window.__booklettoOpenModal && window.__booklettoOpenModal(tab);
        }
        function closeModal(){
            window.__booklettoCloseModal && window.__booklettoCloseModal();
        }
        function handleOv(e){
            if(!e) return;
            if(e.target.id === 'modal') window.__booklettoCloseModal && window.__booklettoCloseModal();
        }
        // ensure clicking modal partial inner buttons doesn't re-hide panels unexpectedly
        document.addEventListener('click', function(e){
            const t = e.target.closest && e.target.closest('[data-open-modal]');
            if(t) {
                e.preventDefault();
                const tab = t.getAttribute('data-open-modal') || 'login';
                openModal(tab);
            }
        });
    </script>
</body>
</html>
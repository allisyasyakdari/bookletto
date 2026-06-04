@extends('layouts.site')

@section('content')
    <div class="relative min-h-[calc(100vh-9rem)] overflow-hidden bg-[linear-gradient(180deg,rgba(0,23,45,0.18)_0%,rgba(0,23,45,0.42)_100%)]">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(201,166,58,0.18),transparent_32%),radial-gradient(circle_at_top_right,rgba(255,255,255,0.2),transparent_30%),linear-gradient(135deg,rgba(0,31,63,0.94),rgba(0,23,45,0.96))] backdrop-blur-md"></div>
        <div class="absolute inset-0 opacity-40 blur-3xl">
            <div class="absolute left-[-10%] top-[8%] h-72 w-72 rounded-full bg-[color:var(--bookletto-gold)]/20"></div>
            <div class="absolute right-[-8%] top-[24%] h-80 w-80 rounded-full bg-white/15"></div>
            <div class="absolute bottom-[-6%] left-[18%] h-96 w-96 rounded-full bg-[color:var(--bookletto-navy-mid)]/40"></div>
        </div>

        <div class="bookletto-shell relative flex min-h-[calc(100vh-9rem)] items-center justify-center py-10">
            @yield('modal')
        </div>
    </div>
@endsection
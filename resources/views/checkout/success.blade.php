@extends('layouts.site')

@section('content')
<section class="bookletto-shell py-12 lg:py-20">

    @if ($order->payment_method === 'qris' && $order->payment_status !== 'paid')
    {{-- ── QRIS Payment Screen ── --}}
    <div class="bookletto-panel bg-white p-8 max-w-lg mx-auto text-center">
        <p class="bookletto-section-label">Selesaikan Pembayaran</p>
        <h1 class="mt-3 text-4xl text-[color:var(--bookletto-navy)]">Scan QRIS</h1>
        <p class="mt-3 text-[color:var(--bookletto-text-mid)]">Pesanan #{{ $order->id }} menunggu pembayaran.</p>

        {{-- QR Code (generated via QR API) --}}
        <div class="mt-6 flex justify-center">
            <div class="rounded-2xl border-4 border-[color:var(--bookletto-gold)] p-3 inline-block bg-white">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode('BOOKLETTO-ORDER-' . $order->id . '-QRIS-REF-' . $order->qris_reference . '-AMOUNT-' . (int)$order->total) }}"
                     alt="QRIS Code" class="h-52 w-52 rounded-xl">
            </div>
        </div>

        <div class="mt-4 rounded-xl bg-amber-50 px-5 py-3">
            <p class="text-xs text-[color:var(--bookletto-text-light)] uppercase tracking-widest">Total yang Harus Dibayar</p>
            <p class="mt-1 text-3xl font-bold text-[color:var(--bookletto-gold)]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-[color:var(--bookletto-text-light)]">Ref: {{ $order->qris_reference }}</p>
        </div>

        <div id="qris-countdown-wrap" class="mt-4 rounded-xl bg-blue-50 border border-blue-200 px-5 py-3 text-sm text-blue-700">
            Scan QR di atas, pembayaran dicek dalam <span id="qris-countdown" class="font-bold">10</span> detik...
        </div>

        <div id="payment-status-box" class="mt-3 rounded-xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-5 py-3 text-sm text-[color:var(--bookletto-text-mid)] hidden">
            <span class="inline-block h-3 w-3 animate-pulse rounded-full bg-amber-400 mr-2"></span>
            Menunggu konfirmasi pembayaran...
        </div>

        <p class="mt-5 text-xs text-[color:var(--bookletto-text-light)]">
            Buka aplikasi m-banking atau e-wallet Anda dan scan QR di atas.<br>
            Status akan diperbarui otomatis setelah pembayaran berhasil.
        </p>
    </div>

    @push('scripts')
    <script>
    (function () {
        const orderId   = {{ $order->id }};
        const checkUrl  = '/checkout/payment-status/' + orderId;
        const statusBox = document.getElementById('payment-status-box');
        const countdownEl = document.getElementById('qris-countdown');
        let attempts = 0;
        const MAX_ATTEMPTS = 60;
        const SCAN_WINDOW  = 10; // seconds to show QR before polling

        // Countdown before polling starts
        let remaining = SCAN_WINDOW;
        function tick() {
            if (!countdownEl) return;
            countdownEl.textContent = remaining;
            if (remaining <= 0) {
                countdownEl.closest('#qris-countdown-wrap').classList.add('hidden');
                startPolling();
                return;
            }
            remaining--;
            setTimeout(tick, 1000);
        }
        tick();

        function startPolling() {
            statusBox.classList.remove('hidden');
            checkPayment();
        }

        function checkPayment() {
            if (attempts >= MAX_ATTEMPTS) {
                statusBox.innerHTML = '<span class="text-red-500">Waktu habis. Hubungi kami jika sudah membayar.</span>';
                return;
            }
            attempts++;

            fetch(checkUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (data.paid) {
                        statusBox.innerHTML = '<span class="text-green-600 font-semibold">✓ Pembayaran berhasil! Mengalihkan...</span>';
                        setTimeout(() => { window.location.reload(); }, 1500);
                    } else {
                        setTimeout(checkPayment, 2000);
                    }
                })
                .catch(() => setTimeout(checkPayment, 2000));
        }
    })();
    </script>
    @endpush

    @elseif ($order->payment_method === 'transfer' && $order->payment_status !== 'paid')
    {{-- ── Transfer instructions ── --}}
    <div class="bookletto-panel bg-white p-8 max-w-lg mx-auto">
        <p class="bookletto-section-label">Instruksi Transfer</p>
        <h1 class="mt-3 text-4xl text-[color:var(--bookletto-navy)]">Pesanan #{{ $order->id }}</h1>
        <p class="mt-3 text-[color:var(--bookletto-text-mid)]">Silakan transfer ke salah satu rekening berikut:</p>

        <div class="mt-5 space-y-3">
            @foreach ([['BCA','1234567890','Bookletto Store'],['Mandiri','0987654321','Bookletto Store'],['BNI','1122334455','Bookletto Store']] as [$bank,$no,$name])
            <div class="flex items-center justify-between rounded-xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3">
                <div>
                    <p class="text-xs text-[color:var(--bookletto-text-light)]">{{ $bank }}</p>
                    <p class="font-mono text-lg font-semibold text-[color:var(--bookletto-navy)]">{{ $no }}</p>
                    <p class="text-xs text-[color:var(--bookletto-text-mid)]">a.n. {{ $name }}</p>
                </div>
                <button onclick="navigator.clipboard.writeText('{{ $no }}')" class="rounded-lg border border-[color:var(--bookletto-border)] px-3 py-1 text-xs">Salin</button>
            </div>
            @endforeach
        </div>

        <div class="mt-5 rounded-xl bg-amber-50 px-5 py-3 text-center">
            <p class="text-xs uppercase tracking-widest text-[color:var(--bookletto-text-light)]">Jumlah Transfer</p>
            <p class="mt-1 text-3xl font-bold text-[color:var(--bookletto-gold)]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
        </div>

        <p class="mt-4 text-xs text-[color:var(--bookletto-text-light)]">Harap transfer tepat sesuai nominal agar pesanan lebih mudah diverifikasi. Konfirmasi pembayaran dapat dilakukan melalui WhatsApp atau email kami.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('home') }}" class="bookletto-button-primary">Kembali ke Home</a>
            <a href="{{ route('orders') }}" class="bookletto-button-secondary">Pesanan Saya</a>
        </div>
    </div>

    @else
    {{-- ── Generic success ── --}}
    <div class="bookletto-panel bg-white p-8">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-green-100">
                <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="bookletto-section-label">Pesanan Berhasil</p>
                <h1 class="mt-1 text-4xl text-[color:var(--bookletto-navy)]">Pesanan #{{ $order->id }}</h1>
            </div>
        </div>

        <p class="mt-4 max-w-2xl text-lg text-[color:var(--bookletto-text-mid)]">
            Terima kasih, {{ $order->customer_name }}! Pesanan Anda sudah dicatat.
            @if($order->payment_status === 'paid') Pembayaran telah dikonfirmasi. @endif
        </p>

        <div class="mt-8 grid gap-4 md:grid-cols-3">
            <div class="bookletto-card p-5">
                <p class="text-sm text-[color:var(--bookletto-text-light)]">Subtotal</p>
                <p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
            </div>
            <div class="bookletto-card p-5">
                <p class="text-sm text-[color:var(--bookletto-text-light)]">Ongkos Kirim</p>
                <p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-navy)]">
                    @if((int)$order->shipping_cost === 0) <span class="text-green-600">Gratis</span> @else Rp {{ number_format($order->shipping_cost, 0, ',', '.') }} @endif
                </p>
            </div>
            <div class="bookletto-card p-5">
                <p class="text-sm text-[color:var(--bookletto-text-light)]">Total Dibayar</p>
                <p class="mt-2 text-2xl font-semibold text-[color:var(--bookletto-gold)]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="mt-6 bookletto-card p-5">
            <p class="text-sm font-semibold text-[color:var(--bookletto-navy)]">Detail Pengiriman</p>
            <p class="mt-2 text-sm text-[color:var(--bookletto-text-mid)]">{{ $order->shipping_address }}</p>
            <p class="mt-1 text-xs text-[color:var(--bookletto-text-light)]">Metode pembayaran: {{ strtoupper($order->payment_method) }}
                @if($order->promo_code) · Promo: {{ $order->promo_code }} @endif
            </p>
        </div>

        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('home') }}" class="bookletto-button-primary">Kembali ke Home</a>
            <a href="{{ route('orders') }}" class="bookletto-button-secondary">Pesanan Saya</a>
        </div>
    </div>
    @endif

</section>
@endsection
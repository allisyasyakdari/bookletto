@extends('layouts.site')

@section('content')
<section class="bookletto-shell py-12 lg:py-20">
    <p class="bookletto-section-label">Checkout</p>
    <h1 class="mt-3 text-5xl text-[color:var(--bookletto-navy)]">Sederhana, Aman, dan Cepat</h1>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4">
            <p class="mb-1 font-semibold text-red-700">Ada kesalahan yang perlu diperbaiki:</p>
            <ul class="list-inside list-disc text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_0.8fr]">

        {{-- ── LEFT: Form ── --}}
        <form id="checkout-form" action="{{ route('checkout.store') }}" method="post" class="bookletto-card space-y-6 p-6" novalidate>
            @csrf

            {{-- Personal info --}}
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nama Penerima <span class="text-red-500">*</span></label>
                    <input name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                           class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3"
                           placeholder="Nama lengkap penerima" required>
                    @error('customer_name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                           class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3"
                           placeholder="08xxxxxxxxxx" required>
                    @error('customer_phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Email <span class="text-red-500">*</span></label>
                <input name="customer_email" type="email" value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                       class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3"
                       placeholder="email@contoh.com" required>
                @error('customer_email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- ── Shipping address dropdowns ── --}}
            <div>
                <p class="mb-3 text-sm font-semibold text-[color:var(--bookletto-navy)]">Alamat Pengiriman <span class="text-red-500">*</span></p>
                <div class="space-y-3">
                    {{-- Province --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[color:var(--bookletto-text-mid)]">Provinsi</label>
                        <select id="select-province" name="province"
                                class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinces as $slug => $label)
                                <option value="{{ $slug }}" {{ old('province') === $slug ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('province')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[color:var(--bookletto-text-mid)]">Kota / Kabupaten</label>
                        <select id="select-city" name="city"
                                class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm" required disabled>
                            <option value="">-- Pilih Kota / Kabupaten --</option>
                        </select>
                        @error('city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- District --}}
                    <div>
                        <label class="mb-1 block text-xs font-medium text-[color:var(--bookletto-text-mid)]">Kecamatan</label>
                        <select id="select-district" name="district"
                                class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm" disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                        @error('district')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    {{-- Detail address --}}
                    <div id="detail-address-wrap" class="hidden">
                        <label class="mb-1 block text-xs font-medium text-[color:var(--bookletto-text-mid)]">Detail Alamat (Nama Jalan, No. Rumah, RT/RW, dll.)</label>
                        <textarea id="detail-address" name="detail_address" rows="3"
                                  class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm"
                                  placeholder="Contoh: Jl. Melati No. 10, RT 02/RW 05">{{ old('detail_address') }}</textarea>
                        @error('detail_address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Shipping cost badge --}}
                <div id="shipping-info" class="mt-3 hidden rounded-xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-[color:var(--bookletto-text-mid)]">Estimasi Ongkos Kirim</span>
                        <span id="shipping-cost-display" class="font-semibold text-[color:var(--bookletto-navy)]">–</span>
                    </div>
                    <p id="shipping-note" class="mt-1 text-xs text-[color:var(--bookletto-text-light)]"></p>
                </div>
            </div>

            {{-- ── Promo code ── --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-[color:var(--bookletto-navy)]">Kode Promo</label>
                <div class="flex gap-2">
                    <input id="promo-input" type="text" placeholder="Masukkan kode promo"
                           class="w-full rounded-2xl border border-[color:var(--bookletto-border)] bg-[color:var(--bookletto-cream)] px-4 py-3 text-sm uppercase tracking-widest"
                           value="{{ $appliedPromo ? $appliedPromo->code : '' }}"
                           {{ $appliedPromo ? 'readonly' : '' }}>
                    <button type="button" id="promo-apply-btn"
                            class="rounded-2xl bg-[color:var(--bookletto-gold)] px-4 py-2 text-sm font-semibold text-white whitespace-nowrap
                                   {{ $appliedPromo ? 'hidden' : '' }}">
                        Terapkan
                    </button>
                    <button type="button" id="promo-remove-btn"
                            class="rounded-2xl border border-red-400 px-4 py-2 text-sm font-semibold text-red-500 whitespace-nowrap
                                   {{ $appliedPromo ? '' : 'hidden' }}">
                        Hapus
                    </button>
                </div>
                <p id="promo-message" class="mt-2 text-sm {{ $appliedPromo ? 'text-green-600' : 'hidden' }}">
                    {{ $appliedPromo ? '✓ Promo "' . $appliedPromo->title . '" berhasil diterapkan.' : '' }}
                </p>
            </div>

            {{-- ── Payment method ── --}}
            <div>
                <p class="mb-3 text-sm font-semibold text-[color:var(--bookletto-navy)]">Metode Pembayaran <span class="text-red-500">*</span></p>
                <div class="grid gap-3 sm:grid-cols-3">
                    {{-- COD --}}
                    <label class="payment-option cursor-pointer rounded-2xl border-2 border-[color:var(--bookletto-border)] p-4 transition-all has-[:checked]:border-[color:var(--bookletto-gold)] has-[:checked]:bg-amber-50">
                        <input type="radio" name="payment_method" value="cod" class="sr-only" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-2 text-center">
                            <svg class="h-7 w-7 text-[color:var(--bookletto-navy)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span class="text-sm font-semibold text-[color:var(--bookletto-navy)]">Bayar di Tempat</span>
                            <span class="text-xs text-[color:var(--bookletto-text-light)]">COD</span>
                        </div>
                    </label>

                    {{-- Transfer --}}
                    <label class="payment-option cursor-pointer rounded-2xl border-2 border-[color:var(--bookletto-border)] p-4 transition-all has-[:checked]:border-[color:var(--bookletto-gold)] has-[:checked]:bg-amber-50">
                        <input type="radio" name="payment_method" value="transfer" class="sr-only" {{ old('payment_method') === 'transfer' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-2 text-center">
                            <svg class="h-7 w-7 text-[color:var(--bookletto-navy)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span class="text-sm font-semibold text-[color:var(--bookletto-navy)]">Transfer Bank</span>
                            <span class="text-xs text-[color:var(--bookletto-text-light)]">BCA / Mandiri / BNI</span>
                        </div>
                    </label>

                    {{-- QRIS --}}
                    <label class="payment-option cursor-pointer rounded-2xl border-2 border-[color:var(--bookletto-border)] p-4 transition-all has-[:checked]:border-[color:var(--bookletto-gold)] has-[:checked]:bg-amber-50">
                        <input type="radio" name="payment_method" value="qris" class="sr-only" {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-2 text-center">
                            <svg class="h-7 w-7 text-[color:var(--bookletto-navy)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 14h3v3m0 4h4m-4 0v-4m-3 4h-1m0-4v4"/></svg>
                            <span class="text-sm font-semibold text-[color:var(--bookletto-navy)]">QRIS</span>
                            <span class="text-xs text-[color:var(--bookletto-text-light)]">Scan & Pay</span>
                        </div>
                    </label>
                </div>
                @error('payment_method')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <button type="submit" id="submit-btn" class="bookletto-button-primary w-full py-4 text-base">
                Buat Pesanan
            </button>
        </form>

        {{-- ── RIGHT: Summary ── --}}
        <div class="bookletto-card h-fit p-6">
            <p class="bookletto-section-label">Ringkasan Pesanan</p>
            <div class="mt-5 space-y-4">
                @foreach ($items as $item)
                    <div class="flex items-start justify-between gap-4 border-b border-[color:var(--bookletto-border)] pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <p class="font-semibold text-[color:var(--bookletto-navy)]">{{ $item['book']->title }}</p>
                            <p class="text-sm text-[color:var(--bookletto-text-mid)]">Qty {{ $item['quantity'] }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.25em] text-[color:var(--bookletto-text-light)]">{{ $item['book']->publisher }} · {{ $item['book']->published_year }}</p>
                        </div>
                        <p class="text-sm font-medium text-[color:var(--bookletto-navy)]">Rp {{ number_format($item['total'], 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 space-y-2 border-t border-[color:var(--bookletto-border)] pt-4 text-sm text-[color:var(--bookletto-text-mid)]">
                <div class="flex items-center justify-between">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div id="summary-discount" class="flex items-center justify-between {{ $discountAmount > 0 ? '' : 'hidden' }}">
                    <span>Diskon <span id="summary-promo-label" class="text-xs">{{ $appliedPromo ? '('.$appliedPromo->code.')' : '' }}</span></span>
                    <span class="text-green-600" id="summary-discount-amount">- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Ongkos Kirim</span>
                    <span id="summary-shipping">
                        @if($shippingCost === 0)
                            <span class="text-green-600 font-semibold">Gratis</span>
                        @else
                            Rp {{ number_format($shippingCost, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="flex items-center justify-between pt-3 text-lg font-semibold text-[color:var(--bookletto-navy)] border-t border-[color:var(--bookletto-border)]">
                    <span>Total</span>
                    <span id="summary-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>{{-- /grid --}}
</section>

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── helpers ─────────────────────────────────────── */
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    function rupiah(n) {
        return 'Rp ' + Number(n).toLocaleString('id-ID');
    }

    async function fetchJson(url, options) {
        const res = await fetch(url, options);
        if (!res.ok) throw new Error('Network error ' + res.status);
        return res.json();
    }

    /* ── initial values from server ──────────────────── */
    const SUBTOTAL        = {{ (int) $subtotal }};
    let   discountAmount  = {{ (int) $discountAmount }};
    let   shippingCost    = {{ (int) $shippingCost }};

    function recalcTotal() {
        const total = Math.max(0, SUBTOTAL - discountAmount) + shippingCost;
        document.getElementById('summary-total').textContent = rupiah(total);
    }

    /* ── dropdowns ───────────────────────────────────── */
    const selProvince = document.getElementById('select-province');
    const selCity     = document.getElementById('select-city');
    const selDistrict = document.getElementById('select-district');
    const detailWrap  = document.getElementById('detail-address-wrap');
    const shippingInfo = document.getElementById('shipping-info');
    const shippingDisplay = document.getElementById('shipping-cost-display');
    const shippingNote    = document.getElementById('shipping-note');

    function populateSelect(sel, data, placeholder) {
        sel.innerHTML = '<option value="">' + placeholder + '</option>';
        Object.entries(data).forEach(([slug, label]) => {
            const opt = document.createElement('option');
            opt.value = slug;
            opt.textContent = label;
            sel.appendChild(opt);
        });
        sel.disabled = Object.keys(data).length === 0;
    }

    selProvince.addEventListener('change', async function () {
        const province = this.value;
        selCity.innerHTML     = '<option value="">Memuat...</option>';
        selDistrict.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
        selCity.disabled      = true;
        selDistrict.disabled  = true;
        detailWrap.classList.add('hidden');
        shippingInfo.classList.add('hidden');

        if (!province) return;

        try {
            const cities = await fetchJson('/checkout/cities?province=' + encodeURIComponent(province));
            populateSelect(selCity, cities, '-- Pilih Kota / Kabupaten --');
        } catch (e) {
            selCity.innerHTML = '<option value="">Gagal memuat kota</option>';
        }
    });

    selCity.addEventListener('change', async function () {
        const city     = this.value;
        const province = selProvince.value;
        selDistrict.innerHTML = '<option value="">Memuat...</option>';
        selDistrict.disabled  = true;
        shippingInfo.classList.add('hidden');

        if (!city) {
            detailWrap.classList.add('hidden');
            return;
        }

        // Show detail address immediately when city is selected
        detailWrap.classList.remove('hidden');

        try {
            const [districts, shipping] = await Promise.all([
                fetchJson('/checkout/districts?city=' + encodeURIComponent(city)),
                fetchJson('/checkout/shipping?province=' + encodeURIComponent(province) + '&city=' + encodeURIComponent(city)),
            ]);

            populateSelect(selDistrict, districts, '-- Pilih Kecamatan --');

            shippingCost = shipping.shipping_cost ?? 0;

            // Update summary shipping
            const summaryShipping = document.getElementById('summary-shipping');
            if (shippingCost === 0) {
                summaryShipping.innerHTML = '<span class="text-green-600 font-semibold">Gratis</span>';
                shippingDisplay.textContent = 'Gratis';
                shippingNote.textContent    = '🎉 Gratis ongkir untuk tujuan Kota Bandar Lampung!';
            } else {
                summaryShipping.textContent = rupiah(shippingCost);
                shippingDisplay.textContent = rupiah(shippingCost);
                shippingNote.textContent    = 'Estimasi ongkir berdasarkan zona pengiriman.';
            }

            shippingInfo.classList.remove('hidden');
            recalcTotal();
        } catch (e) {
            selDistrict.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
        }
    });

    selDistrict.addEventListener('change', function () {
        // detail address already shown after city selection
    });

    /* ── promo ───────────────────────────────────────── */
    const promoInput     = document.getElementById('promo-input');
    const promoApplyBtn  = document.getElementById('promo-apply-btn');
    const promoRemoveBtn = document.getElementById('promo-remove-btn');
    const promoMessage   = document.getElementById('promo-message');

    function updateDiscountSummary() {
        const row   = document.getElementById('summary-discount');
        const label = document.getElementById('summary-promo-label');
        const amt   = document.getElementById('summary-discount-amount');
        if (discountAmount > 0) {
            row.classList.remove('hidden');
            amt.textContent = '- ' + rupiah(discountAmount);
        } else {
            row.classList.add('hidden');
        }
        recalcTotal();
    }

    if (promoApplyBtn) {
        promoApplyBtn.addEventListener('click', async function () {
            const code = promoInput.value.trim();
            if (!code) {
                showPromoMsg('Masukkan kode promo terlebih dahulu.', 'error');
                return;
            }

            promoApplyBtn.disabled = true;
            promoApplyBtn.textContent = '…';

            try {
                const data = await fetchJson('/checkout/apply-promo', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ code }),
                });

                if (data.success) {
                    discountAmount = data.discount_amount ?? 0;
                    updateDiscountSummary();
                    showPromoMsg('✓ ' + data.message, 'success');
                    promoInput.readOnly = true;
                    promoApplyBtn.classList.add('hidden');
                    promoRemoveBtn.classList.remove('hidden');
                    document.getElementById('summary-promo-label').textContent = '(' + code.toUpperCase() + ')';
                } else {
                    showPromoMsg('✗ ' + data.message, 'error');
                }
            } catch (e) {
                showPromoMsg('Gagal menghubungi server. Coba lagi.', 'error');
            } finally {
                promoApplyBtn.disabled = false;
                promoApplyBtn.textContent = 'Terapkan';
            }
        });
    }

    if (promoRemoveBtn) {
        promoRemoveBtn.addEventListener('click', async function () {
            try {
                await fetchJson('/checkout/remove-promo', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                });
                discountAmount = 0;
                updateDiscountSummary();
                promoInput.value    = '';
                promoInput.readOnly = false;
                promoRemoveBtn.classList.add('hidden');
                promoApplyBtn.classList.remove('hidden');
                showPromoMsg('', '');
            } catch (e) {
                showPromoMsg('Gagal menghapus promo.', 'error');
            }
        });
    }

    function showPromoMsg(msg, type) {
        if (!promoMessage) return;
        promoMessage.textContent = msg;
        promoMessage.className   = 'mt-2 text-sm ' + (type === 'success' ? 'text-green-600' : type === 'error' ? 'text-red-500' : 'hidden');
    }

    /* ── form validation before submit ──────────────── */
    const form      = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');

    if (form && submitBtn) {
        form.addEventListener('submit', function (e) {
            const required = [
                { field: 'customer_name',  label: 'Nama Penerima' },
                { field: 'customer_phone', label: 'Nomor Telepon' },
                { field: 'customer_email', label: 'Email' },
                { field: 'province',       label: 'Provinsi' },
                { field: 'city',           label: 'Kota / Kabupaten' },
                { field: 'detail_address', label: 'Detail Alamat' },
            ];

            const missing = required.filter(({ field }) => {
                const el = form.elements[field];
                return !el || !el.value.trim();
            }).map(r => r.label);

            const paymentEl = form.querySelector('input[name="payment_method"]:checked');
            if (!paymentEl) missing.push('Metode Pembayaran');

            if (missing.length) {
                e.preventDefault();
                alert('Harap lengkapi:\n• ' + missing.join('\n• '));
                return;
            }

            submitBtn.disabled     = true;
            submitBtn.textContent  = 'Memproses...';
        });
    }

})();
</script>
@endpush
@endsection
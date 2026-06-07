<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create()
    {
        [$items, $subtotal] = $this->buildCart();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang masih kosong.');
        }

        // Apply promo from session
        $appliedPromo  = null;
        $discountAmount = 0;
        if ($promoSession = session('promo')) {
            $appliedPromo   = Promo::find($promoSession['id']);
            $discountAmount = $this->calculateDiscount($appliedPromo, $subtotal);
        }

        $shippingCost = 0;
        $total        = max(0, $subtotal - $discountAmount) + $shippingCost;

        $provinces = RegionController::provinces();

        return view('checkout.create', compact(
            'items', 'subtotal', 'shippingCost',
            'appliedPromo', 'discountAmount', 'total',
            'provinces'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name'    => ['required', 'string', 'max:120'],
            'customer_email'   => ['required', 'email', 'max:255'],
            'customer_phone'   => ['required', 'string', 'max:30'],
            'province'         => ['required', 'string', 'max:100'],
            'city'             => ['required', 'string', 'max:100'],
            'district'         => ['nullable', 'string', 'max:100'],
            'detail_address'   => ['required', 'string', 'max:1000'],
            'payment_method'   => ['required', 'in:cod,transfer,qris'],
        ]);

        [$items, $subtotal] = $this->buildCart();

        $appliedPromo   = null;
        $discountAmount = 0;
        $promoCode      = null;
        if ($promoSession = session('promo')) {
            $appliedPromo   = Promo::find($promoSession['id']);
            $discountAmount = $this->calculateDiscount($appliedPromo, $subtotal);
            $promoCode      = $promoSession['code'] ?? null;
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang masih kosong.');
        }

        $shippingCost = RegionController::shippingCost($data['province'], $data['city']);
        $total        = max(0, $subtotal - $discountAmount) + $shippingCost;

        // Build full shipping address string
        $allProvinces   = RegionController::provinces();
        $allCities      = RegionController::citiesFor($data['province']);
        $allDistricts   = RegionController::districtsFor($data['city']);
        $provinceLabel  = $allProvinces[$data['province']]  ?? $data['province'];
        $cityLabel      = $allCities[$data['city']]         ?? $data['city'];
        $districtLabel  = isset($data['district']) && $data['district']
            ? ($allDistricts[$data['district']] ?? $data['district'])
            : null;
        $shippingAddress = $data['detail_address']
            . ($districtLabel ? ', Kec. ' . $districtLabel : '')
            . ', ' . $cityLabel . ', Prov. ' . $provinceLabel;

        $paymentStatus = $data['payment_method'] === 'cod' ? 'unpaid' : 'pending';
        $orderStatus   = 'pending';

        $order = DB::transaction(function () use (
            $data, $items, $subtotal, $shippingCost, $total,
            $shippingAddress, $discountAmount, $promoCode,
            $paymentStatus, $orderStatus, $provinceLabel, $cityLabel, $districtLabel
        ) {
            foreach ($items as $item) {
                $book = Book::whereKey($item['book']->id)->lockForUpdate()->first();
                if (! $book || $book->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'stock' => 'Stok "' . ($item['book']->title ?? 'buku') . '" tidak cukup.',
                    ]);
                }
                $book->decrement('stock', $item['quantity']);
            }

            $qrisRef = null;
            if ($data['payment_method'] === 'qris') {
                $qrisRef = strtoupper(Str::random(12));
            }

            $order = Order::create([
                'user_id'          => Auth::id(),
                'customer_name'    => $data['customer_name'],
                'customer_email'   => $data['customer_email'],
                'customer_phone'   => $data['customer_phone'],
                'shipping_address' => $shippingAddress,
                'province'         => $provinceLabel,
                'city'             => $cityLabel,
                'district'         => $districtLabel,
                'subtotal'         => $subtotal,
                'discount_amount'  => $discountAmount,
                'promo_code'       => $promoCode,
                'shipping_cost'    => $shippingCost,
                'total'            => $total,
                'status'           => $orderStatus,
                'payment_method'   => $data['payment_method'],
                'payment_status'   => $paymentStatus,
                'qris_reference'   => $qrisRef,
                'placed_at'        => now(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id'  => $item['book']->id,
                    'quantity' => $item['quantity'],
                    'price'    => $item['book']->price,
                    'total'    => $item['total'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');
        session()->forget('promo');

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        $order->load('items.book.category');
        return view('checkout.success', compact('order'));
    }

    /**
     * AJAX – apply promo code on checkout page.
     */
    public function applyPromo(Request $request)
    {
        $data = $request->validate(['code' => ['required', 'string', 'max:50']]);

        [$items, $subtotal] = $this->buildCart();

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang masih kosong.']);
        }

        $promo = Promo::where('code', $data['code'])->first();

        if (! $promo) {
            return response()->json(['success' => false, 'message' => 'Kode promo tidak ditemukan.']);
        }
        if ($promo->expired_at && $promo->expired_at->isPast()) {
            return response()->json(['success' => false, 'message' => 'Kode promo sudah kadaluarsa.']);
        }
        if ($promo->min_purchase && $subtotal < $promo->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian Rp ' . number_format($promo->min_purchase, 0, ',', '.'),
            ]);
        }

        session()->put('promo', [
            'id'            => $promo->id,
            'code'          => $promo->code,
            'discount_type' => $promo->discount_type ?? 'percent',
            'discount'      => (int) $promo->discount,
            'discount_amount' => (int) $promo->discount_amount,
        ]);

        $discountAmount = $this->calculateDiscount($promo, $subtotal);

        return response()->json([
            'success'        => true,
            'message'        => 'Promo berhasil diterapkan!',
            'discount_amount' => $discountAmount,
            'promo_label'    => $promo->title . ' (' . $promo->code . ')',
        ]);
    }

    /**
     * AJAX – remove promo.
     */
    public function removePromo()
    {
        session()->forget('promo');
        return response()->json(['success' => true]);
    }

    /**
     * AJAX – get cities for a province.
     */
    public function getCities(Request $request)
    {
        $province = $request->get('province', '');
        return response()->json(RegionController::citiesFor($province));
    }

    /**
     * AJAX – get districts for a city.
     */
    public function getDistricts(Request $request)
    {
        $city = $request->get('city', '');
        return response()->json(RegionController::districtsFor($city));
    }

    /**
     * AJAX – get shipping cost.
     */
    public function getShipping(Request $request)
    {
        $province = $request->get('province', '');
        $city     = $request->get('city', '');
        $cost     = RegionController::shippingCost($province, $city);
        return response()->json(['shipping_cost' => $cost]);
    }

    /**
     * AJAX – simulate QRIS payment check (mock).
     * In production this would call a payment gateway API.
     */
    public function checkPayment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            return response()->json(['paid' => false]);
        }

        // Already paid
        if ($order->payment_status === 'paid') {
            return response()->json(['paid' => true]);
        }

        // Simulate: mark as paid after 15 seconds for demo
        if ($order->payment_method === 'qris' && $order->placed_at && now()->diffInSeconds($order->placed_at) >= 15) {
            $order->update(['payment_status' => 'paid', 'status' => 'processing']);
            return response()->json(['paid' => true]);
        }

        return response()->json(['paid' => false]);
    }

    /**
     * Complete payment for transfer / qris order immediately (simulate/auto-confirm).
     */
    public function simulatePayment(Order $order, Request $request)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order)->with('status', 'Pembayaran sudah dikonfirmasi.');
        }

        $order->update([
            'payment_status' => 'paid',
            'status'         => 'processing',
        ]);

        return redirect()->route('checkout.success', $order)->with('status', 'Pembayaran berhasil disimulasikan!');
    }

    // ─────────────────────────────────────────────
    private function buildCart(): array
    {
        $cart  = session()->get('cart', []);
        $books = Book::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)->map(function (int $quantity, int $bookId) use ($books) {
            $book = $books->get($bookId);
            if (! $book) return null;
            return ['book' => $book, 'quantity' => $quantity, 'total' => $book->price * $quantity];
        })->filter()->values();

        return [$items, $items->sum('total')];
    }

    private function calculateDiscount(?Promo $promo, int $subtotal): int
    {
        if (! $promo) return 0;
        if ($promo->discount_type === 'fixed') {
            return min($subtotal, (int) $promo->discount_amount);
        }
        return (int) round($subtotal * ((int) $promo->discount / 100));
    }
}
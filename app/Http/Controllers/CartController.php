<?php

namespace App\Http\Controllers;

use App\Models\Book as BookModel;
use App\Models\Promo;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        [$items, $subtotal] = $this->buildCart();

        $appliedPromo = null;
        if ($promoSession = session('promo')) {
            $appliedPromo = Promo::find($promoSession['id']);
        }

        $discountAmount = $this->calculateDiscount($appliedPromo, $subtotal);
        $total = max(0, $subtotal - $discountAmount);
        $totalAfterDiscount = $total;

        return view('cart.index', compact('items', 'subtotal', 'appliedPromo', 'discountAmount', 'total', 'totalAfterDiscount'));
    }

    public function applyPromo(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        [$items, $subtotal] = $this->buildCart();

        if (empty($items) || $subtotal <= 0) {
            return back()->with('status', 'Keranjang masih kosong.');
        }

        $promo = Promo::where('code', $data['code'])->first();

        if (! $promo) {
            return back()->with('status', 'Kode promo tidak ditemukan.');
        }

        if ($promo->expired_at && $promo->expired_at->isPast()) {
            return back()->with('status', 'Promo sudah kadaluarsa.');
        }

        if ($promo->min_purchase && $subtotal < $promo->min_purchase) {
            return back()->with('status', "Minimal pembelian untuk promo ini Rp " . number_format($promo->min_purchase, 0, ',', '.'));
        }

        session()->put('promo', [
            'id' => $promo->id,
            'code' => $promo->code,
            'discount_type' => $promo->discount_type ?? 'percent',
            'discount' => (int) $promo->discount,
            'discount_amount' => (int) $promo->discount_amount,
        ]);

        return back()->with('status', 'Promo berhasil diterapkan.');
    }

    public function removePromo()
    {
        session()->forget('promo');
        return back()->with('status', 'Promo dihapus.');
    }

    public function add(Request $request, BookModel $book)
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cart = session()->get('cart', []);
        $currentQuantity = (int) ($cart[$book->id] ?? 0);
        $newQuantity = min($book->stock, $currentQuantity + $quantity);

        if ($book->stock <= 0) {
            return back()->with('status', 'Stok buku ini habis.');
        }

        $cart[$book->id] = $newQuantity;

        session()->put('cart', $cart);

        if ($newQuantity === $currentQuantity) {
            return back()->with('status', 'Stok buku ini sudah penuh di keranjang.');
        }

        if ($newQuantity < $currentQuantity + $quantity) {
            return back()->with('status', 'Jumlah di keranjang disesuaikan dengan stok tersedia.');
        }

        return back()->with('status', 'Buku ditambahkan ke keranjang.');
    }

    public function update(Request $request, BookModel $book)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        if ($book->stock <= 0) {
            return back()->with('status', 'Stok buku ini habis.');
        }

        $cart = session()->get('cart', []);
        $cart[$book->id] = min((int) $validated['quantity'], $book->stock);

        session()->put('cart', $cart);

        if ($cart[$book->id] < (int) $validated['quantity']) {
            return back()->with('status', 'Jumlah di keranjang disesuaikan dengan stok tersedia.');
        }

        return back()->with('status', 'Keranjang diperbarui.');
    }

    public function remove(BookModel $book)
    {
        $cart = session()->get('cart', []);
        unset($cart[$book->id]);
        session()->put('cart', $cart);

        return back()->with('status', 'Buku dihapus dari keranjang.');
    }

    private function buildCart(): array
    {
        $cart = session()->get('cart', []);
        $books = BookModel::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)->map(function (int $quantity, int $bookId) use ($books) {
            $book = $books->get($bookId);

            if (! $book) {
                return null;
            }

            $total = $book->price * $quantity;

            return [
                'book' => $book,
                'quantity' => $quantity,
                'total' => $total,
            ];
        })->filter()->values();

        $subtotal = $items->sum('total');

        return [$items, $subtotal];
    }

    private function calculateDiscount(?Promo $promo, int $subtotal): int
    {
        if (! $promo) {
            return 0;
        }

        if ($promo->discount_type === 'fixed') {
            return min($subtotal, (int) $promo->discount_amount);
        }

        return (int) round($subtotal * (((int) $promo->discount) / 100));
    }
}
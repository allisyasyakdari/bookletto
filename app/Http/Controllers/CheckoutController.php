<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function create()
    {
        [$items, $subtotal] = $this->buildCart();

        // apply promo from session if present
        $appliedPromo = null;
        $discountAmount = 0;
        if ($promoSession = session('promo')) {
            $appliedPromo = \App\Models\Promo::find($promoSession['id']);
            $discountAmount = $this->calculateDiscount($appliedPromo, $subtotal);
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang masih kosong.');
        }

        $shippingCost = 0;

        $total = max(0, $subtotal - $discountAmount) + $shippingCost;

        return view('checkout.create', compact('items', 'subtotal', 'shippingCost', 'appliedPromo', 'discountAmount', 'total'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        [$items, $subtotal] = $this->buildCart();

        $appliedPromo = null;
        $discountAmount = 0;
        if ($promoSession = session('promo')) {
            $appliedPromo = \App\Models\Promo::find($promoSession['id']);
            $discountAmount = $this->calculateDiscount($appliedPromo, $subtotal);
        }

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('status', 'Keranjang masih kosong.');
        }

        $shippingCost = 0;
        $total = max(0, $subtotal - $discountAmount) + $shippingCost;

        $order = DB::transaction(function () use ($data, $items, $subtotal, $shippingCost, $total) {
            foreach ($items as $item) {
                $book = Book::whereKey($item['book']->id)->lockForUpdate()->first();

                if (! $book || $book->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'stock' => 'Stok "' . ($item['book']->title ?? 'buku') . '" tidak cukup. Silakan kurangi jumlah di keranjang.',
                    ]);
                }

                $book->decrement('stock', $item['quantity']);
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'shipping_address' => $data['shipping_address'],
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'status' => 'paid',
                'placed_at' => now(),
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item['book']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['book']->price,
                    'total' => $item['total'],
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        $order->load('items.book.category');

        return view('checkout.success', compact('order'));
    }

    private function buildCart(): array
    {
        $cart = session()->get('cart', []);
        $books = Book::with('category')->whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)->map(function (int $quantity, int $bookId) use ($books) {
            $book = $books->get($bookId);

            if (! $book) {
                return null;
            }

            return [
                'book' => $book,
                'quantity' => $quantity,
                'total' => $book->price * $quantity,
            ];
        })->filter()->values();

        $subtotal = $items->sum('total');

        return [$items, $subtotal];
    }

    private function calculateDiscount(?\App\Models\Promo $promo, int $subtotal): int
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
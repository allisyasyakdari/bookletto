<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = Order::with(['items.book', 'user'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->toString();

                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('customer_name', 'ilike', '%' . $keyword . '%')
                        ->orWhere('customer_email', 'ilike', '%' . $keyword . '%')
                        ->orWhere('customer_phone', 'ilike', '%' . $keyword . '%')
                        ->orWhereHas('items.book', function ($bookQuery) use ($keyword) {
                            $bookQuery->where('title', 'ilike', '%' . $keyword . '%');
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderByDesc('placed_at')
            ->orderByDesc('created_at');

        $orders = $ordersQuery->paginate(10)->withQueryString();

        $statusCounts = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $completedThisMonth = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        return view('admin.orders.index', compact('orders', 'statusCounts', 'completedThisMonth'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.book.category');

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,paid,processing,shipped,completed,cancelled'],
        ]);

        $order->update($data);

        return back()->with('status', 'Status order diperbarui.');
    }
}
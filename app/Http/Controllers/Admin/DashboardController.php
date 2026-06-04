<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $endDate = now()->endOfDay();
        $startDate = now()->subDays(6)->startOfDay();

        $stats = [
            'books' => Book::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'users' => \App\Models\User::count(),
            'revenue' => (float) Order::sum('total'),
            'revenue_last_7_days' => (float) Order::whereBetween('created_at', [$startDate, $endDate])->sum('total'),
        ];

        $dailyRevenue = Order::query()
            ->selectRaw('DATE(created_at) as day, COALESCE(SUM(total), 0) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->pluck('total', 'day');

        $salesChart = collect(range(6, 0))->map(function (int $offset) use ($dailyRevenue) {
            $date = Carbon::now()->subDays($offset);
            $key = $date->toDateString();

            return [
                'label' => $date->format('D'),
                'date' => $date->format('d M'),
                'total' => (float) ($dailyRevenue[$key] ?? 0),
            ];
        });

        $recentOrders = Order::with('items.book')
            ->orderByDesc('placed_at')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();
        $popularBooks = Book::query()
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'salesChart', 'popularBooks'));
    }
}
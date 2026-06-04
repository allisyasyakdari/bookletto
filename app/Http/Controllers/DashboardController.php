<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Promo;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard with catalog, promos, and orders.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $searchTerm = trim((string) $request->input('q', ''));
        $selectedCategorySlug = $request->string('category')->toString();
        $selectedCategory = $selectedCategorySlug
            ? Category::where('slug', $selectedCategorySlug)->first()
            : null;

        $recommendedQuery = Book::with('category');
        $bestsellersQuery = Book::with('category')->withCount('orderItems');
        $latestQuery = Book::with('category');

        if ($selectedCategory) {
            $recommendedQuery->where('category_id', $selectedCategory->id);
            $bestsellersQuery->where('category_id', $selectedCategory->id);
            $latestQuery->where('category_id', $selectedCategory->id);
        }

        if ($searchTerm !== '') {
            $recommendedQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('publisher', 'like', '%' . $searchTerm . '%')
                    ->orWhere('synopsis', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });

            $bestsellersQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('publisher', 'like', '%' . $searchTerm . '%')
                    ->orWhere('synopsis', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });

            $latestQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('publisher', 'like', '%' . $searchTerm . '%')
                    ->orWhere('synopsis', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        $recommended = $recommendedQuery->inRandomOrder()->take(8)->get();
        $bestsellers = $bestsellersQuery
            ->orderByDesc('order_items_count')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();
        $latest = $latestQuery->orderByDesc('published_at')->orderByDesc('created_at')->take(8)->get();
        $categories = Category::withCount('books')->orderBy('name')->get();

        $wishlist = $user
            ? $user->wishlistBooks()->with('category')->latest('wishlists.created_at')->take(8)->get()
            : collect();

        $orders = $user
            ? Order::with('items.book.category')
                ->where('user_id', $user->id)
                ->orderByDesc('placed_at')
                ->orderByDesc('created_at')
                ->take(10)
                ->get()
            : collect();

        // load active promos for dashboard sidebar
        $promos = Promo::where(function ($q) {
            $q->whereNull('expired_at')->orWhere('expired_at', '>', Carbon::now());
        })->orderByDesc('discount')->take(4)->get();

        return view('dashboard.index', compact('recommended', 'bestsellers', 'latest', 'wishlist', 'orders', 'promos', 'categories', 'selectedCategory', 'searchTerm'));
    }

    /**
     * Promo page for customers.
     */
    public function promos(Request $request)
    {
        $promos = Promo::orderByDesc('expired_at')
            ->orderByDesc('discount')
            ->get();

        return view('promo.index', compact('promos'));
    }

    /**
     * Orders page for customers.
     */
    public function ordersPage(Request $request)
    {
        $user = $request->user();
        $orders = $user
            ? Order::with('items.book.category')
                ->where('user_id', $user->id)
                ->orderByDesc('placed_at')
                ->orderByDesc('created_at')
                ->get()
            : collect();
        return view('orders.index', compact('orders'));
    }
}

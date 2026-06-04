<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('books')->orderBy('sort_order')->get();
        $bestSellers = Book::with('category')
            ->whereNotNull('cover_image')
            ->where('cover_image', '!=', '')
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();
        $featuredBooks = Book::with('category')
            ->where('is_featured', true)
            ->whereNotNull('cover_image')
            ->where('cover_image', '!=', '')
            ->latest('published_at')
            ->take(8)
            ->get();
        $recommendations = Book::with('category')
            ->whereNotNull('cover_image')
            ->where('cover_image', '!=', '')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return response()
            ->view('home', compact('categories', 'bestSellers', 'featuredBooks', 'recommendations'));
    }
}
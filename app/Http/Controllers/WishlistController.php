<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $books = $user
            ? $user->wishlistBooks()->with('category')->latest('wishlists.created_at')->get()
            : collect();

        return view('wishlist.index', compact('books'));
    }

    public function toggle(Request $request, Book $book)
    {
        $user = $request->user();

        if ($user->wishlistBooks()->whereKey($book->id)->exists()) {
            $user->wishlistBooks()->detach($book->id);

            return back()->with('status', 'Buku dihapus dari wishlist.');
        }

        $user->wishlistBooks()->attach($book->id);

        return back()->with('status', 'Buku disimpan ke wishlist.');
    }
}
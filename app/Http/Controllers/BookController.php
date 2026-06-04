<?php

namespace App\Http\Controllers;

use App\Models\Book as BookModel;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function show(Request $request, BookModel $book)
    {
        $book->load(['category', 'reviews.user']);
        $wishlisted = $request->user()
            ? $request->user()->wishlistBooks()->whereKey($book->id)->exists()
            : false;

        $relatedBooks = BookModel::with('category')
            ->where('category_id', $book->category_id)
            ->whereKeyNot($book->getKey())
            ->latest()
            ->take(4)
            ->get();

        return view('books.show', compact('book', 'relatedBooks', 'wishlisted'));
    }

    public function storeReview(Request $request, BookModel $book)
    {
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        \App\Models\Review::updateOrCreate(
            [
                'book_id' => $book->id,
                'user_id' => $request->user()->id,
            ],
            [
                'rating' => $data['rating'],
                'comment' => $data['comment'],
            ]
        );

        return back()->with('status', 'Ulasan berhasil dikirim.');
    }
}
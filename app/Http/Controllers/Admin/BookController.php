<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('sort_order')->get();

        $books = Book::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q')->toString();

                $query->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('title', 'ilike', '%' . $keyword . '%')
                        ->orWhere('author', 'ilike', '%' . $keyword . '%');
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->integer('category'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validateBook($request);
        $data['slug'] = Str::slug($data['title']);
        $data['format'] = 'Cetak';
        $data['cover_gradient'] = 'gradient-1';

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        if (Book::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . Str::lower(Str::random(5));
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('sort_order')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validateBook($request, $book->id);
        $data['slug'] = Str::slug($data['title']);
        $data['format'] = 'Cetak';
        $data['cover_gradient'] = 'gradient-1';

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        if (Book::where('slug', $data['slug'])->whereKeyNot($book->id)->exists()) {
            $data['slug'] .= '-' . Str::lower(Str::random(5));
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('status', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return back()->with('status', 'Buku berhasil dihapus.');
    }

    private function validateBook(Request $request, ?int $bookId = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:160', Rule::unique('books', 'title')->ignore($bookId)],
            'author' => ['required', 'string', 'max:160'],
            'publisher' => ['nullable', 'string', 'max:160'],
            'published_year' => ['nullable', 'integer', 'min:1900', 'max:' . now()->addYear()->year],
            'synopsis' => ['required', 'string', 'max:3000'],
            'price' => ['required', 'numeric', 'min:1000'],
            'stock' => ['required', 'integer', 'min:0'],
            'pages' => ['nullable', 'integer', 'min:1'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_bestseller' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
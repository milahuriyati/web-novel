<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with(['penulis', 'category'])
                     ->where('status', 'published')
                     ->latest()
                     ->get();

        return view('welcome', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        
        return view('backend.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            // Gambar akan disimpan ke folder: storage/app/public/covers
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create([
            'user_id' => Auth::id(), 
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title'] . '-' . time()), 
            'description' => $validated['description'],
            'cover_image' => $coverPath,
            'status' => 'draft', 
        ]);

        return redirect('/dashboard')->with('success', 'Buku baru berhasil disimpan sebagai Draft!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki akses untuk mengedit buku ini.');
        }

        $categories = \App\Models\Category::all();
        return view('backend.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:draft,published', // Validasi untuk fitur Publish/Draft
        ]);

        $coverPath = $book->cover_image;
        if ($request->hasFile('cover_image')) {
            // Hapus cover lama dari storage jika ada agar tidak memenuhi server
            if ($book->cover_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($book->cover_image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($book->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => \Illuminate\Support\Str::slug($validated['title'] . '-' . time()),
            'description' => $validated['description'],
            'cover_image' => $coverPath,
            'status' => $validated['status'], // Menyimpan status draft/published
        ]);

        return redirect('/dashboard')->with('success', 'Buku berhasil diperbarui!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = \App\Models\Book::findOrFail($id);

        if ($book->user_id !== Auth::id()) {
            abort(403);
        }

        $book->delete();

        return redirect('/dashboard')->with('success', 'Buku berhasil dihapus!');
    }
}

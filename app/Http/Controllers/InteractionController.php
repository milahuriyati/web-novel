<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function toggleLike(Book $book)
    {
        $userId = Auth::id();

        // Cek apakah user sudah pernah like buku ini
        $existingLike = Like::where('user_id', $userId)->where('book_id', $book->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return redirect()->back()->with('success', 'Batal menyukai buku ini.');
        } else {
            Like::create([
                'user_id' => $userId,
                'book_id' => $book->id
            ]);
            return redirect()->back()->with('success', 'Buku berhasil disukai! ❤️');
        }
    }

    // 2. Fitur Simpan Komentar (dan Balasan Komentar)
    public function storeComment(Request $request, Book $book)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id // Bernilai id jika membalas komentar orang lain
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}

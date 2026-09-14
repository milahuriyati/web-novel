<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\User;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Book $book)
    {
        $user = $request->user();

        // toggle() otomatis menambahkan jika belum ada di tabel pivot, dan menghapus jika sudah ada
        $user->favoriteBooks()->toggle($book->id);

        return back()->with('success', 'Status favorit berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Pastikan user harus login dulu sebelum berkomentar
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu.');
        }

        $request->validate([
            'chapter_id' => 'required|exists:chapters,id',
            'body' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Digunakan jika membalas komentar lain
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'chapter_id' => $request->chapter_id,
            'body' => $request->body,
            'parent_id' => $request->parent_id, // Null jika komentar baru, terisi id comment lain jika balasan
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}
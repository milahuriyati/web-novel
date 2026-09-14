<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, Chapter $chapter)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Cek apakah user sudah pernah nge-like chapter ini
        $like = Like::where('user_id', Auth::id())
                    ->where('chapter_id', $chapter->id)
                    ->first();

        if ($like) {
            // Jika sudah ada, hapus (artinya user melakukan UNLIKE)
            $like->delete();
            $message = 'Batal menyukai bab ini.';
        } else {
            // Jika belum ada, buat baru (artinya user melakukan LIKE)
            Like::create([
                'user_id' => Auth::id(),
                'chapter_id' => $chapter->id
            ]);
            $message = 'Bab disukai!';
        }

        return redirect()->back()->with('success', $message);
    }
}
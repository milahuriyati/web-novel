<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\ReadingHistory;
use App\Models\ReadingLog; // Import model ReadingLog
use Carbon\Carbon;         // Import Carbon untuk tanggal
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function show(string $slug, int $chapter_number)
    {
        $book = Book::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Ambil chapter beserta komentar utamanya (parent_id null) dan balasannya (replies)
        $chapter = Chapter::where('book_id', $book->id)
            ->where('chapter_number', $chapter_number)
            ->firstOrFail();

        // =========================================================
        // LOGIKA BARU: Tambah Total Views (Mencegah Spam Refresh)
        // =========================================================
        if (Auth::check()) {
            $userId = Auth::id();
            $chapter->increment('views');

            // --- A. Fitur Lanjutkan Membaca (Bookmark) ---
            ReadingHistory::updateOrCreate(
                ['user_id' => $userId, 'book_id' => $book->id],
                ['chapter_id' => $chapter->id]
            );
            // =========================================================

            // 1. Ambil komentar khusus untuk chapter ini
            // Menggunakan eager loading (.user) supaya tidak terjadi masalah N+1 query
            $comments = $chapter->comments()
                ->whereNull('parent_id') // Hanya ambil komentar utama (bukan balasan)
                ->with(['user', 'replies.user']) // Ambil pengirim komentar & balasan beserta pengirimnya
                ->latest()
                ->get();

            // 2. Hitung jumlah total like di chapter ini
            $likesCount = $chapter->likes()->count();

            // 3. Cek apakah user yang login sudah nge-like chapter ini
            $hasLiked = false;

            if (Auth::check()) {
                $userId = Auth::id();

                // --- A. Fitur Lanjutkan Membaca (Bookmark) ---
                ReadingHistory::updateOrCreate(
                    ['user_id' => $userId, 'book_id' => $book->id],
                    ['chapter_id' => $chapter->id]
                );

                // --- B. Fitur Tracking untuk "Wrapped" (Baru Ditambahkan) ---
                $today = Carbon::today()->toDateString();

                // Cek apakah hari ini user sudah membaca bab ini agar tidak double-record
                $logExists = ReadingLog::where('user_id', $userId)
                    ->where('book_id', $book->id)
                    ->where('chapter_id', $chapter->id)
                    ->whereDate('created_at', $today)
                    ->exists();

                if (!$logExists) {
                    // Jika belum tercatat hari ini, tambahkan log baru (asumsi 1 bab = 5 menit)
                    ReadingLog::create([
                        'user_id' => $userId,
                        'book_id' => $book->id,
                        'chapter_id' => $chapter->id,
                        'read_duration_minutes' => 5,
                    ]);
                }

                // --- C. Cek status like ---
                $hasLiked = $chapter->likes()->where('user_id', $userId)->exists();
            }

            $previousChapter = Chapter::where('book_id', $book->id)
                ->where('chapter_number', $chapter_number - 1)
                ->first();

            $nextChapter = Chapter::where('book_id', $book->id)
                ->where('chapter_number', $chapter_number + 1)
                ->first();

            // Kirim semua variabel tambahan ke view 'frontend.chapters.show'
            return view('frontend.chapters.show', compact(
                'book',
                'chapter',
                'previousChapter',
                'nextChapter',
                'comments',
                'likesCount',
                'hasLiked'
            ));
        }
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
}

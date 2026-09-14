<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category; // 1. Jangan lupa import model Category
use Illuminate\Http\Request;

class FrontendBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 2. Ambil semua kategori untuk dikirim ke dropdown View
        $categories = Category::all();

        // Ambil buku yang statusnya 'published'
        $query = Book::with(['category', 'penulis'])->where('status', 'published');

        // Jika user mengetikkan sesuatu di kotak pencarian judul/deskripsi
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Tambahkan Logika Filter Kategori di sini
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Ambil datanya dengan pagination (misal 12 buku per halaman)
        $books = $query->latest()->paginate(12);

        // 4. Sisipkan $categories ke compact() agar bisa dipakai di Blade
        return view('frontend.books.index', compact('books', 'categories'));
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
    public function show(string $slug)
    {
        $book = Book::with([
                'category', 
                'penulis', 
                'comments', 
                'chapters' => function($query) {
                    // Mencegah N+1 Query pada jumlah like di masing-masing bab
                    $query->withCount('likes')->orderBy('chapter_number', 'asc');
                }
            ])
            ->withCount('likes') // Menghitung total likes buku (jika ada)
            ->withSum('chapters', 'views') // <-- LOGIKA BARU: Menjumlahkan kolom 'views' dari semua bab
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('frontend.books.show', compact('book'));
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

    public function welcome()
    {
        // 1. Rekomendasi Terbaru (Buku rilis ter-update)
        $books = Book::with(['category', 'penulis'])
            ->where('status', 'published')
            ->latest()
            ->take(8)
            ->get();

        // 2. Saran Untuk Anda (Bisa dibuat random, atau berdasarkan kategori yang di-follow user nanti)
        // Untuk sekarang kita acak 2 buku sebagai contoh
        $recommendedBooks = Book::with(['category', 'penulis'])
            ->where('status', 'published')
            ->inRandomOrder()
            ->take(2)
            ->get();

        // 3. Kategori dengan buku terbanyak
        $topGenre = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->first();

        // 4. Kategori paling diminati (misalnya berdasarkan total views atau likes)
        // Jika belum ada views, fallback ke random kategori dulu
        $popularGenre = Category::inRandomOrder()->first(); 

        // 5. Buku per kategori teratas (Ambil 3 kategori, tampilkan 4 buku per kategori)
        $categoriesWithBooks = Category::with(['books' => function($query) {
                $query->where('status', 'published')->latest()->take(4);
            }])
            ->has('books', '>=', 1) // Pastikan kategori punya minimal 1 buku
            ->take(3)
            ->get();

        return view('frontend.welcome', compact(
            'books', 
            'recommendedBooks', 
            'topGenre', 
            'popularGenre', 
            'categoriesWithBooks'
        ));
    }
}
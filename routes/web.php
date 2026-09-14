<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FrontendBookController;
use App\Http\Controllers\FrontendChapterController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReaderDashboardController;
use App\Http\Controllers\ReadingStatisticController;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// =========================================================================
// PUBLIC ROUTES (Bisa diakses oleh Guest / Pengunjung tanpa Login)
// =========================================================================
Route::get('/', [FrontendBookController::class, 'welcome'])->name('welcome');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])
    ->name('frontend.categories.show');

// Detail Buku (Halaman Utama Buku / Daftar Isi)
Route::get('/buku/{slug}', [FrontendBookController::class, 'show'])->name('frontend.books.show');


// =========================================================================
// PROTECTED ROUTES (Harus Login & Akun TIDAK Banned)
// =========================================================================
// Tambahkan 'check.blocked' di grup utama ini
Route::middleware(['auth', 'verified', 'check.blocked'])->group(function () {
    
    // Dashboard router berdasarkan Role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role ?? 'pembaca'; 
        
        if ($role === 'admin') {
            return app(AdminDashboardController::class)->index();
        } elseif ($role === 'penulis') {
            $user = Auth::user();
            $myBooks = Book::where('user_id', $user->id)->latest()->get();
            $readHistories = \App\Models\ReadingHistory::with(['book', 'chapter'])
                                ->where('user_id', $user->id)
                                ->orderBy('updated_at', 'desc')
                                ->get();
            return view('backend.dashboard.penulis', compact('user', 'myBooks', 'readHistories'));
        } else {            
            return app(ReaderDashboardController::class)->index();
        }
    })->name('dashboard');

    // Route Jelajah
    Route::get('/jelajahi', [FrontendBookController::class, 'index'])->name('frontend.books.index');

    // Halaman Baca Isi Bab Buku (Dipindahkan ke atas agar rapi & aman terlindungi)
    Route::get('/buku/{slug}/bab/{chapter_number}', [FrontendChapterController::class, 'show'])
        ->name('frontend.chapters.show');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/upgrade', [ProfileController::class, 'upgrade'])->name('profile.upgrade');

    // Fitur Interaksi: Kirim Komentar, Like, & Favorit
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/chapters/{chapter}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
    Route::post('/buku/{book}/favorite', [FavoriteController::class, 'toggle'])->name('books.favorite');
    Route::post('/buku/{book}/like', [InteractionController::class, 'toggleLike'])->name('books.like');
    Route::post('/buku/{book}/comment', [InteractionController::class, 'storeComment'])->name('books.comment');

    // Route untuk melihat statistik membaca (My Wrapped)
    Route::get('/my-wrapped', [ReadingStatisticController::class, 'index'])->name('user.wrapped');

    // =========================================================================
    // ROLE: PENULIS & ADMIN
    // =========================================================================
    Route::middleware('role:penulis,admin')->group(function () {
        // CRUD Buku
        Route::resource('books', BookController::class);

        // CRUD Bab Buku
        Route::get('/books/{book}/chapters', [ChapterController::class, 'index'])->name('chapters.index');
        Route::get('/books/{book}/chapters/create', [ChapterController::class, 'create'])->name('chapters.create');
        Route::post('/books/{book}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
        Route::post('/chapters/upload-image', [ChapterController::class, 'uploadImage'])->name('chapters.upload_image');
        Route::get('/chapters/{chapter}/edit', [ChapterController::class, 'edit'])->name('chapters.edit');
        Route::put('/chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
        Route::delete('/chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
    });

    // =========================================================================
    // ROLE: ADMIN ONLY
    // =========================================================================
    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::delete('/admin/books/{book}', [AdminDashboardController::class, 'destroyBook'])->name('admin.books.destroy');        
        Route::delete('/admin/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::patch('/admin/users/{user}/block', [AdminDashboardController::class, 'block'])->name('admin.users.block');
        Route::patch('/admin/users/{user}/unblock', [AdminDashboardController::class, 'unblock'])->name('admin.users.unblock');
    });
});

require __DIR__.'/auth.php';
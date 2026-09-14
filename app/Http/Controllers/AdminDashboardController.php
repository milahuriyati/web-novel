<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPembaca = User::where('role', 'pembaca')->count();
        $totalPenulis = User::where('role', 'penulis')->count();
        $totalBuku = Book::where('status', 'published')->count();
        $totalDiblokir = User::where('is_banned', true)->count(); 
        $user = Auth::user();
        
        $tahunIni = Carbon::now()->year;

        // --- DATA GRAFIK USER BARU ---
        $usersPerBulan = User::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunIni)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $bulanUser = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataUser = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataUser[] = $usersPerBulan[$i] ?? 0; 
        }

        // --- DATA GRAFIK BUKU RILIS ---
        $bukuPerBulan = Book::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahunIni)
            ->where('status', 'published') // Hanya hitung buku yang sudah rilis/publish
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $bulanBuku = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataBuku = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBuku[] = $bukuPerBulan[$i] ?? 0; 
        }

        $users = User::all();
        $books = Book::all();

        return view('backend.dashboard.admin', compact(
            'totalPembaca', 'totalPenulis', 'totalBuku', 'totalDiblokir',
            'user', 'bulanUser', 'dataUser', 'bulanBuku', 'dataBuku',
            'users', 'books' // Tambahkan ini!
        ));
    }

    // Fungsi untuk menghapus buku secara paksa
    public function destroyBook(Book $book)
    {
        // Hapus cover image jika ada (opsional tapi disarankan agar storage tidak penuh)
        if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus secara paksa dari sistem.');
    }

    // Fungsi untuk menghapus akun user
    public function destroyUser(User $user)
    {
        // Proteksi: Admin tidak boleh tidak sengaja menghapus akunnya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tindakan ditolak: Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus secara permanen.');
    }

    public function block(User $user)
    {
        // Ubah dari 'status' => 'blocked' menjadi kolom aslimu: 'is_banned' => true
        $user->update([
            'is_banned' => true
        ]);

        return redirect()->back()->with('success', 'User berhasil diblokir!');
    }
    public function unblock(User $user)
    {
        // Ubah status is_banned menjadi false (0)
        $user->update([
            'is_banned' => false
        ]);

        return redirect()->back()->with('success', 'Blokir akun pengguna berhasil dibuka!');
    }
}
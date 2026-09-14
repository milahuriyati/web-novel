<?php

namespace App\Http\Controllers;

use App\Models\ReadingLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingStatisticController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Hitung total durasi membaca bulan ini (dalam menit)
        $totalMinutesThisMonth = ReadingLog::where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('read_duration_minutes');

        // Konversi ke jam dan menit agar lebih enak dibaca (misal: 2 Jam 15 Menit)
        $hours = floor($totalMinutesThisMonth / 60);
        $minutes = $totalMinutesThisMonth % 60;
        $formattedDuration = $hours > 0 ? "{$hours} Jam {$minutes} Menit" : "{$minutes} Menit";

        // 2. Hitung total bab yang dibaca bulan ini
        $totalChaptersRead = ReadingLog::where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // 3. Cari Buku Terfavorit Bulan Ini (Buku yang bab-nya paling banyak dibaca)
        $favoriteBookLog = ReadingLog::with('book')
            ->selectRaw('book_id, COUNT(*) as read_count')
            ->where('user_id', $userId)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->groupBy('book_id')
            ->orderByDesc('read_count')
            ->first();

        $favoriteBook = $favoriteBookLog ? $favoriteBookLog->book : null;

        return view('profile.wrapped', compact(
            'totalMinutesThisMonth',
            'formattedDuration',
            'totalChaptersRead',
            'favoriteBook'
        ));
    }
}
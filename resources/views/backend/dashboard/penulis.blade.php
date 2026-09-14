<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

<div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Notifikasi Sukses -->
            @if (session('success') || session('status'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-2xl shadow-sm text-sm flex items-center gap-2 animate-fade-in" role="alert">
                    <span>✨</span>
                    <span class="font-medium">{{ session('success') ?? session('status') }}</span>
                </div>
            @endif

            <!-- Kartu Sambutan & Ringkasan Statistik -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Akses akun: Penulis & Pembaca Aktif</p>
                </div>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <!-- Stat Buku Karya -->
                    <div class="bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl text-center min-w-[100px] flex-1 md:flex-initial">
                        <span class="block text-[10px] text-blue-600 font-bold uppercase tracking-wider">Karya Buku</span>
                        <span class="text-xl font-black text-blue-700">{{ $myBooks->count() }}</span>
                    </div>
                    <!-- Stat Riwayat Membaca -->
                    <div class="bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-xl text-center min-w-[100px] flex-1 md:flex-initial">
                        <span class="block text-[10px] text-indigo-600 font-bold uppercase tracking-wider">Buku Dibaca</span>
                        <span class="text-xl font-black text-indigo-700">{{ $readHistories->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Tata Letak Utama (Grid Dinamis) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- ================= PANEL KIRI: STUDIO PENULIS (2 KOLOM) ================= -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    Kelola Karya Buku Saya
                                </h3>
                                <p class="text-gray-400 text-xs mt-0.5">Tulis, perbarui, dan pantau status publikasi novel tulisanmu</p>
                            </div>
                            <a href="{{ route('books.create') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-100 hover:shadow-none transition w-full sm:w-auto justify-center">
                                <span>+ Tulis Buku Baru</span>
                            </a>
                        </div>

                        <!-- Tabel Daftar Buku -->
                        <div class="overflow-hidden bg-white rounded-xl border border-gray-100">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100 text-left text-sm text-gray-600">
                                    <thead class="bg-gray-50 text-[11px] uppercase font-bold text-gray-500 tracking-wider">
                                        <tr>
                                            <th class="px-5 py-3.5">Cover</th>
                                            <th class="px-5 py-3.5">Judul Buku</th>
                                            <th class="px-5 py-3.5">Kategori</th>
                                            <th class="px-5 py-3.5">Status</th>
                                            <th class="px-5 py-3.5 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @forelse($myBooks as $book)
                                            <tr class="hover:bg-gray-50/70 transition">
                                                <!-- Cover Buku -->
                                                <td class="px-5 py-4 whitespace-nowrap">
                                                    @if ($book->cover_image)
                                                        <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                            alt="Cover"
                                                            class="w-10 h-14 object-cover rounded-lg shadow-sm border border-gray-100">
                                                    @else
                                                        <div class="w-10 h-14 bg-gray-50 rounded-lg flex items-center justify-center text-[9px] text-gray-400 border border-gray-100 text-center p-1 font-medium">
                                                            Kosong
                                                        </div>
                                                    @endif
                                                </td>

                                                <!-- Judul Buku -->
                                                <td class="px-5 py-4 font-semibold text-gray-900 truncate max-w-[180px]">
                                                    {{ $book->title }}
                                                </td>

                                                <!-- Kategori -->
                                                <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-500">
                                                    {{ $book->category->name ?? 'Umum' }}
                                                </td>

                                                <!-- Status -->
                                                <td class="px-5 py-4 whitespace-nowrap">
                                                    @if ($book->status === 'published')
                                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-lg border border-emerald-100 uppercase tracking-wider">Published</span>
                                                    @else
                                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-lg border border-amber-100 uppercase tracking-wider">Draft</span>
                                                    @endif
                                                </td>

                                                <!-- Kelompok Tombol Aksi -->
                                                <td class="px-5 py-4 whitespace-nowrap text-center space-x-1">
                                                    <a href="{{ route('chapters.index', $book->id) }}"
                                                        class="inline-block px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-bold rounded-lg transition">
                                                        Bab
                                                    </a>
                                                    <a href="{{ route('books.edit', $book->id) }}"
                                                        class="inline-block px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-600 text-xs font-bold rounded-lg transition">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                        class="inline-block"
                                                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus buku ini beserta seluruh babnya?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-lg transition">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-5 py-10 text-center text-gray-400 text-sm italic">
                                                    Kamu belum menulis karya buku apapun. Yuk ketuk tombol tambah untuk mulai membuat!
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>                       

                    </div>
                    <div class="mb-8 bg-white p-6 rounded-lg shadow border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Grafik Total Pembaca per Buku</h4>
                        <div class="relative h-72 w-full">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- ================= PANEL KANAN: AKTIVITAS MEMBACA (1 KOLOM) ================= -->
                <div class="space-y-6">
                    
                    <!-- Kotak 1: Terakhir Dibaca (Dinamis) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                            Terakhir Dibaca
                        </h3>
                        
                        @if($readHistories && $readHistories->count() > 0)
                            <div class="space-y-3">
                                @foreach($readHistories as $history)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-blue-200 transition">
                                        <div class="truncate max-w-[65%]">
                                            <h4 class="font-bold text-gray-800 text-xs truncate">{{ $history->book->title }}</h4>
                                            <p class="text-[10px] text-gray-400 truncate mt-0.5">Bab {{ $history->chapter->chapter_number }} - {{ $history->chapter->title }}</p>
                                        </div>
                                        <a href="{{ route('frontend.chapters.show', ['slug' => $history->book->slug, 'chapter_number' => $history->chapter->chapter_number]) }}" 
                                           class="px-2.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold rounded-lg shadow-sm transition whitespace-nowrap">
                                            Lanjut
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-gray-100 rounded-xl py-8 text-center">
                                <p class="text-gray-400 text-xs italic">Belum ada riwayat baca.</p>
                                <a href="/" class="mt-2 inline-block text-[11px] font-bold text-blue-600 hover:underline">Cari Novel &rarr;</a>
                            </div>
                        @endif
                    </div>

                    <!-- Kotak 2: Buku Favorit Saya (Placeholder) -->
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <h3 class="text-md font-bold text-gray-900 mb-4 flex items-center gap-2">
                            ⭐ Buku Favorit Saya
                        </h3>
                        
                        @if(Auth::user()->favoriteBooks && Auth::user()->favoriteBooks->count() > 0)
                            <div class="space-y-3">
                                @foreach(Auth::user()->favoriteBooks as $favBook)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-amber-200 transition">
                                        <div class="flex items-center gap-3 truncate max-w-[70%]">
                                            @if ($favBook->cover_image)
                                                <img src="{{ asset('storage/' . $favBook->cover_image) }}"
                                                    alt="Cover"
                                                    class="w-8 h-11 object-cover rounded-lg shadow-sm border border-gray-100 shrink-0">
                                            @else
                                                <div class="w-8 h-11 bg-gray-100 rounded-lg flex items-center justify-center text-[8px] text-gray-400 text-center p-0.5 shrink-0 border border-gray-100">
                                                    No Cover
                                                </div>
                                            @endif
                                            <div class="truncate">
                                                <h4 class="font-bold text-gray-800 text-xs truncate">{{ $favBook->title }}</h4>
                                                <p class="text-[10px] text-gray-400 truncate mt-0.5">{{ $favBook->category->name ?? 'Umum' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-1.5">
                                            <!-- Tombol Baca (Sesuaikan nama rute detail buku kamu) -->
                                            <a href="{{ route('books.show', $favBook->id) }}" 
                                            class="px-2.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-bold rounded-lg shadow-sm transition whitespace-nowrap">
                                                Baca
                                            </a>
                                            
                                            <!-- Tombol Hapus Cepat dari Dashboard -->
                                            <form action="{{ route('books.favorite', $favBook->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="p-1.5 text-gray-400 hover:text-rose-500 rounded-lg hover:bg-rose-50 transition" title="Hapus dari Favorit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="border-2 border-dashed border-gray-100 rounded-xl py-8 text-center">
                                <p class="text-gray-400 text-xs italic">Belum ada buku favorit disimpan.</p>
                                <a href="/" class="mt-2 inline-block text-[11px] font-bold text-amber-600 hover:underline">Jelajahi Novel &rarr;</a>
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 1. Siapkan data dari PHP (Laravel) ke format Javascript
        // Kita ambil judul buku untuk label bawah (Sumbu X)
        const bookTitles = @json($myBooks->pluck('title'));
        
        // 2. Kita hitung total views dari setiap buku untuk data grafik (Sumbu Y)
        const bookViews = @json($myBooks->map(function($book) {
            // Asumsi data views dijumlahkan dari relasi chapters seperti di halaman detail
            return $book->chapters->sum('views');
        }));

        // 3. Konfigurasi dan Render Grafik
        const ctx = document.getElementById('viewsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Bisa diubah ke 'line' (garis) atau 'pie' (lingkaran)
            data: {
                labels: bookTitles,
                datasets: [{
                    label: 'Total Views (Dilihat)',
                    data: bookViews,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)', // Warna biru Tailwind (blue-500) transparan
                    borderColor: 'rgba(59, 130, 246, 1)', // Warna garis tepi
                    borderWidth: 2,
                    borderRadius: 4, // Bikin ujung bar sedikit melengkung
                    hoverBackgroundColor: 'rgba(37, 99, 235, 0.7)' // Warna saat di-hover (blue-600)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Agar angka di sumbu Y tidak desimal (karena view pasti bilangan bulat)
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
</x-app-layout>
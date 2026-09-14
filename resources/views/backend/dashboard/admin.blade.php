<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-end mb-6">
            <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm rounded-xl shadow-sm hover:shadow transition-all duration-200">
                📂 Kelola Kategori Buku
            </a>
        </div>
        
        {{-- Kartu Ringkasan Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 hover:shadow-md transition-shadow">
                <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Pembaca</h3>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($totalPembaca ?? 0) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 hover:shadow-md transition-shadow">
                <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Total Penulis</h3>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($totalPenulis ?? 0) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">Buku Terbit</h3>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($totalBuku ?? 0) }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-red-500 hover:shadow-md transition-shadow">
                <h3 class="text-gray-500 text-sm font-semibold uppercase tracking-wider mb-1">User Diblokir</h3>
                <p class="text-3xl font-extrabold text-gray-800">{{ number_format($totalDiblokir ?? 0) }}</p>
            </div>
        </div>

        {{-- Area Grafik / Report --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800">Grafik Pendaftaran User Baru</h3>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800">Grafik Buku Rilis (Tahun Ini)</h3>
                </div>
                <div class="relative h-64 w-full">
                    <canvas id="bookChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Area Tabel --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Tabel Pengguna --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-lg text-gray-800">Daftar Pengguna</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Nama Pengguna</th>
                                <th class="px-6 py-3 font-semibold">Peran</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-xs font-semibold">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right flex justify-end gap-2">
                                    {{-- Jika user BELUM diblokir, tampilkan tombol Blokir --}}
                                    @if(!$user->is_banned)
                                        <form action="{{ route('admin.users.block', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memblokir user ini?')">
                                            @csrf @method('PATCH')
                                            <button class="inline-flex items-center px-3 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-md text-xs font-bold transition-all duration-200">
                                                🔒 Blokir
                                            </button>
                                        </form>
                                    {{-- Jika user SUDAH diblokir, tampilkan tombol Unblock --}}
                                    @else
                                        <form action="{{ route('admin.users.unblock', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membuka blokir user ini?')">
                                            @csrf @method('PATCH')
                                            <button class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-600 hover:bg-green-500 hover:text-white rounded-md text-xs font-bold transition-all duration-200">
                                                🔓 Unblock
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-md text-xs font-bold transition-all duration-200">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tabel Buku --}}
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-lg text-gray-800">Daftar Buku Terkini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Judul Buku</th>
                                <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach($books as $book)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 font-medium">{{ $book->title }}</td>
                                <td class="px-6 py-3 text-right">
                                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-md text-xs font-bold transition-all duration-200">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Import CDN Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Script Inisialisasi Grafik --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // --- 1. Grafik User Baru (Line Chart) ---
            const ctxUser = document.getElementById('userChart').getContext('2d');
            const userLabels = {!! json_encode($bulanUser ?? ['Belum Ada Data']) !!};
            const userData = {!! json_encode($dataUser ?? [0]) !!};

            new Chart(ctxUser, {
                type: 'line', 
                data: {
                    labels: userLabels,
                    datasets: [{
                        label: 'Jumlah User Baru',
                        data: userData,
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(59, 130, 246, 0.15)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } 
                    },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });

            // --- 2. Grafik Buku Rilis (Bar Chart) ---
            const ctxBook = document.getElementById('bookChart').getContext('2d');
            const bookLabels = {!! json_encode($bulanBuku ?? ['Belum Ada Data']) !!};
            const bookData = {!! json_encode($dataBuku ?? [0]) !!};

            new Chart(ctxBook, {
                type: 'bar',
                data: {
                    labels: bookLabels,
                    datasets: [{
                        label: 'Buku Rilis',
                        data: bookData,
                        backgroundColor: '#a855f7',
                        borderRadius: 6,
                        barPercentage: 0.6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 } // Lebih rapi untuk hitungan buku
                        },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</x-app-layout>
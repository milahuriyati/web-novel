<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Novelku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <a href="/" class="text-xl font-bold text-blue-600 tracking-tight">Novelku</a>
                <a href="/" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Jelajah Katalog</a>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 capitalize">Role: {{ Auth::user()->role ?? 'Pembaca' }}</p>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 px-3 py-2 rounded-xl transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <aside class="lg:col-span-1">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-200 space-y-1">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Menu Utama</p>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                        Dashboard Utama
                    </a>

                    @if(Auth::user()->role === 'penulis' || Auth::user()->role === 'admin')
                        <div class="pt-4 mt-4 border-t border-gray-100 space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Studio Penulis</p>
                            
                            <a href="{{ route('books.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Kelola Buku Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Grafik & Analitik
                            </a>
                        </div>
                    @endif

                    @if(Auth::user()->role === 'admin')
                        <div class="pt-4 mt-4 border-t border-gray-100 space-y-1">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Manajemen Admin</p>
                            
                            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                Kelola Kategori
                            </a>
                        </div>
                    @endif
                </div>
            </aside>

            <main class="lg:col-span-3">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>
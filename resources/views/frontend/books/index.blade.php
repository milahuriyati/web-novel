<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pencarian Buku - Novelku') }}
        </h2>
    </x-slot>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-10">
        
        <!-- Form Pencarian & Filter Kategori -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Cari Novel Favoritmu</h1>
            <p class="text-gray-500 mb-6">Jelajahi berbagai karya dari penulis terbaik kami.</p>
            
            <form action="{{ url('/jelajahi') }}" method="GET" class="max-w-3xl mx-auto flex flex-col sm:flex-row gap-3">
                
                <!-- Input Cari Judul -->
                <div class="flex-grow">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari judul atau sinopsis buku..." 
                        class="w-full shadow-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 px-4 py-3">
                </div>

                <!-- Dropdown Kategori -->
                <div class="sm:w-1/3">
                    <select name="category" class="w-full shadow-sm border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 px-4 py-3 bg-white">
                        <option value="">Semua Kategori</option>
                        {{-- Looping daftar kategori dari Controller --}}
                        @if(isset($categories))
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Tombol Cari -->
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition shrink-0">
                    Cari
                </button>
            </form>
        </div>

        <!-- Daftar Buku -->
        @if($books->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col">
                        <div class="relative w-full h-64 bg-gray-200">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover {{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 italic text-sm">
                                    No Cover
                                </div>
                            @endif
                            
                            <!-- PERUBAHAN DI SINI: Ditambahkan operator null-safe (?->) -->
                            <div class="absolute top-2 right-2 bg-black bg-opacity-70 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $book->category?->name ?? 'Umum' }}
                            </div>
                        </div>
                        
                        <!-- Info Buku -->
                        <div class="p-4 flex flex-col flex-grow">
                            <!-- PERUBAHAN DI SINI: Ditambahkan operator null-safe (?->) -->
                            <span class="text-xs font-semibold text-blue-600 uppercase tracking-wider mb-1">
                                {{ $book->category?->name ?? 'Uncategorized' }}
                            </span>
                            
                            <h2 class="text-lg font-bold text-gray-900 mt-1 line-clamp-1">
                                <a href="{{ url('/buku/' . $book->slug) }}" class="hover:text-blue-600">{{ $book->title }}</a>
                            </h2>
                            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                ✍️ {{ $book->penulis?->name ?? 'Anonim' }}
                            </p>
                            
                            <!-- Deskripsi disingkat (line-clamp-3) -->
                            <p class="text-sm text-gray-600 mt-3 line-clamp-3 flex-grow">
                                {{ $book->description }}
                            </p>
                            
                            <a href="{{ url('/buku/' . $book->slug) }}" class="mt-4 block text-center text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 py-2 rounded-lg transition">
                                Baca Sekarang
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-10">
                {{ $books->withQueryString()->links() }}
            </div>
        @else
            <!-- Tampilan Jika Buku Tidak Ditemukan -->
            <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <div class="text-4xl mb-4">🔍</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Buku tidak ditemukan</h3>
                <p class="text-gray-500 mb-4">Maaf, tidak ada buku yang sesuai dengan pencarian atau filtermu.</p>
                <a href="{{ url('/jelajahi') }}" class="text-blue-600 font-semibold hover:underline inline-block">
                    &larr; Hapus Filter & Kembali
                </a>
            </div>
        @endif

    </main>
</x-app-layout>
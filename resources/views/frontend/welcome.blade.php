<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6">Jelajahi Dunia Tanpa Batas</h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">
                Temukan ribuan cerita epik, mulai dari romansa, aksi, hingga kisah petualangan <em>reverse isekai</em> yang seru dari para penulis berbakat.
            </p>
        </div>
    </div>

    <!-- Section 1: Saran untuk Anda (Personalisasi) -->
    <div class="bg-indigo-50 border-b border-indigo-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">✨ Saran Untuk Anda</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($recommendedBooks as $book)
                    <div class="bg-white rounded-xl shadow-sm border border-indigo-100 p-4 flex gap-4 hover:shadow-md transition-shadow">
                        <div class="w-24 h-32 flex-shrink-0 bg-gray-200 rounded-lg overflow-hidden">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover {{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 italic text-sm">
                                    No Cover
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col justify-between flex-grow">
                            <div>
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-1 rounded mb-2 inline-block">
                                    Cocok untukmu
                                </span>
                                <h3 class="font-bold text-gray-900 text-lg line-clamp-1">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500 mb-2">Karya {{ $book->penulis->name ?? 'Anonim' }}</p>
                                <p class="text-gray-600 text-xs line-clamp-2">{{ $book->description }}</p>
                            </div>
                            <a href="{{ route('frontend.books.show', $book->slug) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-bold mt-2">
                                Mulai Baca &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada saran khusus untuk saat ini.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Section 2: Highlight Genre (Terbanyak & Diminati) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Genre Terbanyak -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-emerald-100 font-semibold text-sm uppercase tracking-wider mb-1">Genre Terbanyak</h3>
                    <h2 class="text-3xl font-extrabold mb-2">{{ $topGenre->name ?? 'Fantasy' }}</h2>
                    <p class="text-emerald-50 text-sm mb-4">Genre dengan jumlah buku terbanyak yang dipublikasikan oleh penulis kami.</p>
                </div>
                <div class="absolute -bottom-4 -right-4 opacity-20 transform rotate-12">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path></svg>
                </div>
            </div>

            <!-- Genre Paling Diminati -->
            <div class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-rose-100 font-semibold text-sm uppercase tracking-wider mb-1">Paling Diminati Pembaca</h3>
                    <h2 class="text-3xl font-extrabold mb-2">{{ $popularGenre->name ?? 'Romance' }}</h2>
                    <p class="text-rose-50 text-sm mb-4">Genre yang paling banyak dibaca dan disukai minggu ini.</p>
                </div>
                <div class="absolute -bottom-4 -right-4 opacity-20 transform -rotate-12">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 3: Rekomendasi Terbaru -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Rekomendasi Terbaru</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($books as $book)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="relative w-full h-56 bg-gray-200">
                       @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover {{ $book->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 italic text-sm">
                                No Cover
                            </div>
                        @endif
                        
                        <!-- PERUBAHAN DI SINI: Ditambahkan tanda ? setelah category untuk menghindari crash jika null -->
                        <div class="absolute top-2 right-2 bg-black bg-opacity-70 text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $book->category?->name ?? 'Umum' }}
                        </div>
                    </div>
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="text-md font-bold text-gray-900 mb-1 line-clamp-2" title="{{ $book->title }}">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-500 mb-3">Karya <span class="font-semibold text-gray-700">{{ $book->penulis->name ?? 'Anonim' }}</span></p>
                        <a href="{{ route('frontend.books.show', $book->slug) }}" class="mt-auto block w-full text-center bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-1.5 px-3 rounded-lg text-sm transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section 4: Koleksi Berdasarkan Kategori Top -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mb-12 border-t border-gray-200">
        @foreach ($categoriesWithBooks as $category)
            @if($category->books->isNotEmpty())
                <div class="mb-10">
                    <div class="flex flex-row justify-between items-center mb-6 border-b border-gray-100 pb-2">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full inline-block"></span>
                            {{ $category->name }} Terpopuler
                        </h2>
                        
                        <a href="{{ route('frontend.categories.show', $category->slug ?? $category->id) }}" 
                        class="group flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Lihat Semua
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($category->books as $book)
                            <div class="group cursor-pointer">
                                <div class="relative w-full h-64 bg-gray-200 rounded-lg overflow-hidden mb-3">
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover {{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 italic text-sm">
                                            No Cover
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                        <a href="{{ route('frontend.books.show', $book->slug) }}" class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 font-bold py-2 px-4 rounded-full text-sm transform translate-y-4 group-hover:translate-y-0 transition-all">
                                            Baca Sekarang
                                        </a>
                                    </div>
                                </div>
                                <h3 class="font-bold text-gray-900 text-md line-clamp-1">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $book->penulis->name ?? 'Anonim' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</x-app-layout>
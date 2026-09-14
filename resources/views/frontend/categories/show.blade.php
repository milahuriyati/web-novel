<x-app-layout>
    <!-- Header Kategori -->
    <div class="bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-500 mb-2">
                <a href="/" class="hover:text-blue-600">Home</a> / <span>Kategori</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">{{ $category->name }}</h1>
            <p class="text-gray-600 mt-2">Menampilkan {{ $books->total() }} buku dalam kategori ini.</p>
        </div>
    </div>

    <!-- Daftar Buku -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($books->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($books as $book)
                    <div class="group cursor-pointer">
                        <div class="relative w-full h-64 bg-gray-200 rounded-lg overflow-hidden mb-3 shadow-sm">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 italic text-sm">No Cover</div>
                            @endif
                            
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                                <a href="{{ route('frontend.books.show', $book->slug) }}" 
                                   class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 font-bold py-2 px-4 rounded-full text-sm transform translate-y-4 group-hover:translate-y-0 transition-all">
                                    Baca Sekarang
                                </a>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-900 text-md line-clamp-1">{{ $book->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $book->penulis->name ?? 'Anonim' }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination (Link Navigasi Halaman) -->
            <div class="mt-12">
                {{ $books->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-gray-500 text-lg">Belum ada buku dalam kategori ini.</p>
                <a href="/" class="text-blue-600 hover:underline mt-4 block">Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</x-app-layout>
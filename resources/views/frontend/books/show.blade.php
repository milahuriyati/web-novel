<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Buku: ') . $book->title }}
        </h2>
    </x-slot>

    <main class="max-w-4xl mx-auto px-4 py-8 pb-12">
        
        {{-- Tombol Kembali --}}
        <div class="mb-6">
            <button onclick="window.history.back()" class="text-lg font-bold text-blue-600 hover:text-blue-800 transition">&larr; Kembali ke Katalog</button>
        </div>
        
        {{-- Detail Buku --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col md:flex-row mb-8">
            <div class="md:w-1/3 h-80 md:h-auto bg-gray-200 relative">
                @if ($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover"
                        class="w-full h-full object-cover">
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">No Cover</div>
                @endif
            </div>

            <div class="p-6 md:w-2/3 flex flex-col justify-center">
                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full mb-3 w-max">
                    {{ $book->category->name ?? 'Umum' }}
                </span>
                
                <h1 class="text-3xl font-extrabold mb-2">{{ $book->title }}</h1>
                <p class="text-gray-600 font-medium mb-4">Ditulis oleh: <span class="text-gray-900">{{ $book->penulis->name }}</span></p>

                <div class="prose prose-sm text-gray-700 mb-6">
                    <p>{{ $book->description }}</p>
                </div>

                {{-- Fitur Status View, Like, Komentar, & Favorit --}}
                <div class="flex flex-wrap items-center gap-3 mb-6">
                    
                    {{-- Total View dari Semua Bab (Tidak bisa diklik) --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border border-gray-200 bg-white text-gray-600 cursor-default">
                        👁️ <span>{{ $book->chapters->sum('views') }} Dilihat</span>
                    </div>

                    {{-- Total Like dari Semua Bab (Tidak bisa diklik) --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border cursor-default 
                        {{ Auth::check() && $book->isLikedBy(Auth::user()) ? 'bg-rose-50 border-rose-200 text-rose-600' : 'bg-white border-gray-200 text-gray-600' }}">
                        ❤️ <span>{{ $book->chapters->sum(fn($chapter) => $chapter->likes_count ?? $chapter->likes()->count()) }} Suka</span>
                    </div>

                    {{-- Total Komentar Buku (Tidak bisa diklik) --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border border-gray-200 bg-white text-gray-600 cursor-default">
                        💬 <span>{{ $book->comments_count ?? $book->comments()->count() }} Komentar</span>
                    </div>

                    {{-- Tombol Favorit (Bisa diklik jika sudah login, jika belum akan diarahkan ke halaman login) --}}
                    @auth
                        <form action="{{ route('books.favorite', $book->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border transition duration-200
                                {{ $book->isFavoritedBy(Auth::user()) ? 'bg-yellow-50 border-yellow-200 text-yellow-600 hover:bg-yellow-100' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                                ⭐ <span>{{ $book->isFavoritedBy(Auth::user()) ? 'Favorit Saya' : 'Tambah Favorit' }}</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border border-gray-200 bg-white text-gray-400 hover:bg-gray-50 transition duration-200">
                            ⭐ <span>Tambah Favorit</span>
                        </a>
                    @endauth
                </div>
                {{-- Navigasi Lanjut Membaca --}}
                <div class="mt-2">
                    @if (Auth::check() && $book->lastRead)
                        {{-- Jika user login dan memiliki riwayat membaca --}}
                        <a href="{{ route('frontend.chapters.show', ['slug' => $book->slug, 'chapter_number' => $book->lastRead->chapter->chapter_number]) }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-sm transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                            </svg>
                            Lanjutkan Membaca (Bab {{ $book->lastRead->chapter->chapter_number }})
                        </a>
                    @else
                        {{-- Pengunjung baru / belum ada riwayat, arahkan ke Bab 1 --}}
                        @if ($book->chapters->count() > 0)
                            <a href="{{ route('frontend.chapters.show', ['slug' => $book->slug, 'chapter_number' => 1]) }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition duration-200">
                                Mulai Membaca
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        {{-- Daftar Isi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4 border-b pb-2">Daftar Isi</h2>

            @if ($book->chapters->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach ($book->chapters as $chapter)
                        <li class="py-3 flex justify-between items-center hover:bg-gray-50 transition px-2 rounded">
                            <span class="font-medium text-gray-800">Bab {{ $chapter->chapter_number }}: {{ $chapter->title }}</span>

                            <a href="{{ route('frontend.chapters.show', ['slug' => $book->slug, 'chapter_number' => $chapter->chapter_number]) }}"
                                class="text-blue-600 font-semibold hover:text-blue-800 text-sm bg-blue-50 px-4 py-2 rounded-lg">
                                Baca Bab
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 text-center py-8 italic">Penulis belum menerbitkan bab untuk buku ini.</p>
            @endif
        </div>
        
    </main>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembaca') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Banner Welcome -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900">Selamat Datang, {{ $user->name }}! 👋</h1>
                    <p class="text-gray-500 text-sm mt-0.5">Email terdaftar: {{ $user->email }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('profile.upgrade') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin bergabung menjadi Penulis di Novelku?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                            ✍️ Mulai Menulis
                        </button>
                    </form>
                </div>
            </div>

            <!-- Grid Riwayat & Favorit -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Riwayat Baca -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Terakhir Dibaca</h2>
                    @if($readHistories && $readHistories->count() > 0)
                        <div class="space-y-3">
                            @foreach($readHistories as $history)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                    <div class="truncate max-w-[65%]">
                                        <h4 class="font-bold text-gray-800 text-sm truncate">{{ $history->book->title }}</h4>
                                        <p class="text-xs text-gray-500 truncate">Bab {{ $history->chapter->chapter_number }}</p>
                                    </div>
                                    <a href="{{ route('frontend.chapters.show', ['slug' => $history->book->slug, 'chapter_number' => $history->chapter->chapter_number]) }}" class="px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg shadow-sm">Lanjut Baca</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-200 rounded-xl py-12 text-center">
                            <p class="text-gray-400 text-sm italic">Belum ada riwayat membaca saat ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Buku Favorit -->
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
</x-app-layout>
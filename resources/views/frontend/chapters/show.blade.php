<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bab {{ $chapter->chapter_number }}: {{ $chapter->title }} - {{ $book->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-amber-50/40 font-sans antialiased text-gray-900"> <!-- Warna background agak krem hangat agar mata tidak lelah -->

    <!-- Notifikasi Alert / Toast Minimalis -->
    @if(session('success') || session('error'))
        <div id="toast" class="fixed top-5 right-5 z-50 max-w-sm rounded-xl p-4 shadow-lg border transition-all duration-300 transform translate-y-0 opacity-100 {{ session('success') ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800' }}">
            <div class="flex items-center gap-2">
                <span>{{ session('success') ?? session('error') }}</span>
                <button onclick="document.getElementById('toast').remove()" class="ml-auto font-bold hover:opacity-75">&times;</button>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if(toast) {
                    toast.classList.add('translate-y-[-20px]', 'opacity-0');
                    setTimeout(() => toast.remove(), 300);
                }
            }, 4000);
        </script>
    @endif

    <!-- Navbar Minimalis -->
    <nav class="bg-white shadow-sm sticky top-0 z-40">
        <div class="max-w-3xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('frontend.books.show', $book->slug) }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 flex items-center gap-1">
                &larr; Keluar dari Mode Baca
            </a>
            <span class="text-xs font-semibold bg-gray-100 text-gray-600 px-3 py-1 rounded-full max-w-[200px] truncate">
                {{ $book->title }}
            </span>
        </div>
    </nav>

    <!-- Konten Bacaan -->
    <main class="max-w-2xl mx-auto px-4 py-12">
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
            
            <!-- Judul Bab -->
            <header class="text-center mb-8 border-b pb-6">
                <p class="text-sm font-bold text-blue-600 uppercase tracking-wider mb-1">Bab {{ $chapter->chapter_number }}</p>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">{{ $chapter->title }}</h1>
            </header>

            <!-- Isi Novel -->
            <div class="prose prose-base md:prose-lg text-gray-800 leading-relaxed font-serif whitespace-pre-line">
                {!! $chapter->content !!}
            </div>

            <style>
                .isi-novel h1 { font-size: 2em; font-weight: bold; margin-bottom: 0.5em; }
                .isi-novel h2 { font-size: 1.5em; font-weight: bold; margin-top: 1em; margin-bottom: 0.5em; }
                .isi-novel h3 { font-size: 1.17em; font-weight: bold; margin-top: 1em; margin-bottom: 0.5em; }
                .isi-novel strong, .isi-novel b { font-weight: 700 !important; color: #111827; }
                .isi-novel p { margin-bottom: 1.25em; }
                .isi-novel img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1em auto; }
            </style>

            <!-- AREA INTERAKSI: LIKE BUTTON -->
            <div class="mt-12 pt-6 border-t flex justify-center">
                <form action="{{ route('likes.toggle', $chapter->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2.5 px-6 py-3 rounded-full border transition-all duration-200 {{ $hasLiked ? 'bg-rose-50 border-rose-200 text-rose-600 shadow-sm' : 'bg-gray-50 border-gray-200 text-gray-600 hover:bg-rose-50 hover:border-rose-200 hover:text-rose-600' }}">
                        @if($hasLiked)
                            <!-- Icon Hati Aktif (Filled) -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 transform scale-110 transition-transform group-hover:scale-125">
                                <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                            </svg>
                        @else
                            <!-- Icon Hati Non-Aktif (Outline) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6 transition-transform group-hover:scale-110">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        @endif
                        <span class="font-bold text-sm">{{ $likesCount }} Menyukai</span>
                    </button>
                </form>
            </div>

            <!-- Navigasi Bab -->
            <footer class="mt-8 pt-6 border-t flex flex-col sm:flex-row justify-between items-center gap-4">
                @if($previousChapter)
                    <a href="{{ route('frontend.chapters.show', ['slug' => $book->slug, 'chapter_number' => $previousChapter->chapter_number]) }}" 
                    class="w-full sm:w-auto text-center px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition text-sm">
                        &larr; Bab Sebelumnya
                    </a>
                @else
                    <span class="hidden sm:block"></span>
                @endif

                <a href="{{ route('frontend.books.show', $book->slug) }}" 
                class="w-full sm:w-auto text-center px-5 py-2.5 bg-blue-50 text-blue-600 font-semibold rounded-xl hover:bg-blue-100 transition text-sm">
                    Daftar Isi
                </a>

                @if($nextChapter)
                    <a href="{{ route('frontend.chapters.show', ['slug' => $book->slug, 'chapter_number' => $nextChapter->chapter_number]) }}" 
                    class="w-full sm:w-auto text-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition shadow-sm text-sm">
                        Bab Selanjutnya &rarr;
                    </a>
                @else
                    <span class="w-full sm:w-auto text-center px-5 py-2.5 bg-green-50 text-green-700 font-semibold text-sm rounded-xl italic">
                        🎉 Bab Terakhir
                    </span>
                @endif
            </footer>

        </article>

        <!-- KOTAK/AREA KOMENTAR (Berada di luar kartu novel agar layout lebih rapi) -->
        <section class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <span>💬 Komentar</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-0.5 rounded-full font-semibold">
                    {{ $comments->count() }}
                </span>
            </h2>

            <!-- Form Kirim Komentar Baru -->
            @auth
                <form action="{{ route('comments.store') }}" method="POST" class="mb-8">
                    @csrf
                    <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                    <div class="mb-3">
                        <textarea name="body" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 text-sm transition-all placeholder:text-gray-400" placeholder="Tulis pendapat atau teori kamu tentang bab ini..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition shadow-sm">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 border border-dashed rounded-2xl p-6 text-center mb-8">
                    <p class="text-sm text-gray-600">Mau ikut berdiskusi di bab ini?</p>
                    <a href="/login" class="mt-2 inline-block text-sm font-bold text-blue-600 hover:underline">
                        Masuk / Login Terlebih Dahulu &rarr;
                    </a>
                </div>
            @endauth

            <!-- List Komentar -->
            <div class="space-y-6">
                @forelse($comments as $comment)
                    <div class="border-b border-gray-50 pb-6 last:border-none last:pb-0">
                        <!-- Header Komentar -->
                        <div class="flex items-start gap-3">
                            <!-- MODIFIKASI: Cek Apakah User Komentar Utama Punya Avatar -->
                            @if($comment->user->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" 
                                    alt="Avatar {{ $comment->user->name }}" 
                                    class="w-10 h-10 rounded-full border border-gray-200 object-cover shrink-0">
                            @else
                                <!-- Fallback: Avatar Inisial User jika tidak pasang foto -->
                                <div class="w-10 h-10 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center font-bold text-blue-600 text-sm uppercase shrink-0">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <div class="grow">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-sm text-gray-800">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-400">• {{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-1 leading-relaxed">{{ $comment->body }}</p>

                                <!-- Tombol Aksi Balas (Hanya untuk yang login) -->
                                @auth
                                    <button onclick="toggleReplyForm('{{ $comment->id }}')" class="mt-2 text-xs text-blue-600 font-semibold hover:underline flex items-center gap-1">
                                        Balas
                                    </button>

                                    <!-- Form Balasan (Hidden secara default) -->
                                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-3 max-w-lg">
                                        <form action="{{ route('comments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="chapter_id" value="{{ $chapter->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <textarea name="body" rows="2" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400" placeholder="Tulis balasan..." required></textarea>
                                            <div class="mt-1.5 flex gap-2">
                                                <button type="submit" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">Kirim</button>
                                                <button type="button" onclick="toggleReplyForm('{{ $comment->id }}')" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-lg transition">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <!-- Balasan Komentar (Nested Replies) -->
                        @if($comment->replies->count() > 0)
                            <div class="mt-4 pl-12 space-y-4 border-l-2 border-gray-100/80 ml-5">
                                @foreach($comment->replies as $reply)
                                    <div class="flex items-start gap-3">
                                        <!-- MODIFIKASI: Cek Apakah User Balasan Punya Avatar -->
                                        @if($reply->user->avatar)
                                            <img src="{{ asset('storage/' . $reply->user->avatar) }}" 
                                                alt="Avatar {{ $reply->user->name }}" 
                                                class="w-8 h-8 rounded-full border border-gray-200 object-cover shrink-0">
                                        @else
                                            <!-- Fallback: Avatar Balasan Inisial jika tidak pasang foto -->
                                            <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center font-bold text-gray-600 text-xs uppercase shrink-0">
                                                {{ substr($reply->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-xs text-gray-800">{{ $reply->user->name }}</span>
                                                <span class="text-[10px] text-gray-400">• {{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $reply->body }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-sm text-gray-400">Belum ada komentar di bab ini. Jadilah yang pertama berkomentar!</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <!-- JavaScript Ringan untuk Menampilkan/Menyembunyikan Form Balas -->
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            if (form) {
                form.classList.toggle('hidden');
            }
        }
    </script>
</body>
</html>
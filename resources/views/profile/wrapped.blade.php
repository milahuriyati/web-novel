<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novel Wrapped') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            
            <!-- Wrapper Utama dengan Efek Gradient -->
            <div id="wrapped-card" class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-3xl shadow-2xl p-8 md:p-12 text-white text-center relative overflow-hidden">
                
                <!-- Ornamen Dekorasi Background -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>

                <!-- Header -->
                <div class="relative z-10 mb-10">
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-3 tracking-tight">Novel Wrapped 📚</h1>
                    <p class="text-lg md:text-xl text-indigo-100 font-medium">Rekap perjalanan imajinasimu bulan ini!</p>
                </div>

                <!-- Grid Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
                    
                    <!-- Kartu 1: Waktu Membaca -->
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6 border border-white/30 shadow-lg hover:-translate-y-1 transition-transform duration-300">
                        <div class="text-5xl mb-4">⏱️</div>
                        <h3 class="text-lg text-indigo-100 font-semibold mb-2">Total Waktu</h3>
                        <p class="text-2xl md:text-3xl font-bold">{{ $formattedDuration }}</p>
                        <p class="text-sm text-indigo-200 mt-2">({{ $totalMinutesThisMonth }} menit)</p>
                    </div>

                    <!-- Kartu 2: Bab Diselesaikan -->
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6 border border-white/30 shadow-lg hover:-translate-y-1 transition-transform duration-300">
                        <div class="text-5xl mb-4">📖</div>
                        <h3 class="text-lg text-indigo-100 font-semibold mb-2">Bab Dibaca</h3>
                        <p class="text-4xl font-bold">{{ $totalChaptersRead }}</p>
                        <p class="text-sm text-indigo-200 mt-2">Bab diselesaikan</p>
                    </div>

                    <!-- Kartu 3: Buku Favorit -->
                    <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6 border border-white/30 shadow-lg hover:-translate-y-1 transition-transform duration-300">
                        <div class="text-5xl mb-4">🏆</div>
                        <h3 class="text-lg text-indigo-100 font-semibold mb-2">Paling Sering Dibaca</h3>
                        @if($favoriteBook)
                            <p class="text-xl md:text-2xl font-bold truncate px-2" title="{{ $favoriteBook->title }}">
                                {{ $favoriteBook->title }}
                            </p>
                            <p class="text-sm text-indigo-200 mt-2">Karya favoritmu bulan ini</p>
                        @else
                            <p class="text-xl font-bold mt-2">Belum Ada</p>
                            <p class="text-sm text-indigo-200 mt-2">Yuk, mulai baca sekarang!</p>
                        @endif
                    </div>

                </div>

                <!-- Tombol Aksi -->
                <div class="mt-12 relative z-10">
                    <button onclick="downloadWrapped()" class="bg-white text-purple-700 font-bold py-3 px-8 rounded-full ...">
                        📸 Download Gambar Wrapped
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        function downloadWrapped() {
            const element = document.getElementById('wrapped-card');
            html2canvas(element, {
                scale: 2, // Biar gambarnya tajam (high resolution)
                backgroundColor: null
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'my-novel-wrapped.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            });
        }
    </script>
</x-app-layout>
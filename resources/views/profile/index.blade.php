<x-app-layout>
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- 1. Banner Cover: Menggunakan gradasi warna senada dengan tema aplikasi -->
            <div class="h-40 bg-gradient-to-r from-blue-600 via-blue-400 to-white relative">
                <!-- Hiasan ornamen samar di dalam cover -->
                <div class="absolute inset-0 bg-black/10 mix-blend-overlay"></div>
            </div>
            
            <!-- Bagian Utama Info User -->
            <div class="px-6 sm:px-12 pb-8 flex flex-col items-center -mt-20 relative z-10">
                
                <!-- 2. Foto Profil dengan Ring Border Tebal -->
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=6366f1&color=fff&size=128&bold=true' }}" 
                alt="Foto Profil" 
                class="w-36 h-36 rounded-full border-4 border-white shadow-xl mb-4 bg-white object-cover">
                
                <!-- Nama User -->
                <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">{{ $user->name }}</h1>
                
                <!-- 3. Badge Peran Dinamis -->
                <div class="mt-2">
                    @if(($user->role ?? 'pembaca') === 'admin')
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-xs font-bold uppercase tracking-wider rounded-full border border-red-200 shadow-sm">
                            🛡️ {{ $user->role }}
                        </span>
                    @elseif(($user->role ?? 'pembaca') === 'penulis')
                        <span class="px-3 py-1 bg-purple-50 text-purple-600 text-xs font-bold uppercase tracking-wider rounded-full border border-purple-200 shadow-sm">
                            ✍️ {{ $user->role }}
                        </span>
                    @else
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider rounded-full border border-blue-200 shadow-sm">
                            📖 {{ $user->role }}
                        </span>
                    @endif
                </div>

                <p class="text-gray-400 text-sm mt-2 mb-4 font-medium">{{ $user->email }}</p>
                
                <!-- 4. Ruang Bio Singkat -->
                

                <!-- 5. Grid Statistik Ringkas (Bikin Profil Nggak Kelihatan Kosong) -->
                
                <div class="grid grid-cols-3 gap-4 w-full max-w-md text-center bg-slate-50 p-4 rounded-2xl border border-slate-100 mb-6">
                    <!-- Menghitung total buku favorit melalui relasi belongsToMany -->
                    <div>
                        <span class="block text-xl font-bold text-gray-800">
                            {{ $user->favoriteBooks->count() }}
                        </span>
                        <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Favorit</span>
                    </div>
                    
                    <!-- Statistik Tengah: Fleksibel mengikuti Peran (Role) User -->
                    <div class="border-x border-slate-200">
                        @if($user->role === 'penulis')
                            <span class="block text-xl font-bold text-gray-800">
                                {{ $user->books->count() }}
                            </span>
                            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Buku Rilis</span>
                        @else
                            <span class="block text-xl font-bold text-gray-800">
                                {{ $user->comments->count() }}
                            </span>
                            <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Ulasan</span>
                        @endif
                    </div>
                    
                    <!-- Menampilkan bulan & tahun user mendaftar secara otomatis -->
                    <div>
                        <span class="block text-sm font-bold text-gray-800 mt-1">
                            {{ $user->created_at ? $user->created_at->format('M Y') : 'Juli 2026' }}
                        </span>
                        <span class="text-xs text-gray-400 font-semibold uppercase tracking-wider block mt-1">Bergabung</span>
                    </div>
                </div>
                
                <!-- Garis Pemisah Tipis -->
                <div class="w-full h-px bg-gray-100 mb-6"></div>
                
                <!-- 6. Tombol Aksi Akhir -->
                <div class="flex flex-col sm:flex-row gap-4 w-full justify-center max-w-md">
                    
                    <!-- Tombol Edit Profil -->
                    <a href="{{ route('profile.edit') }}" class="px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl shadow-sm hover:bg-slate-200 transition-all duration-200 text-center flex-1 text-sm flex items-center justify-center gap-2">
                        ✏️ Edit Profil
                    </a>

                    <!-- Tombol Novel Wrapped -->
                    <a href="{{ route('user.wrapped') }}" 
                       class="w-full inline-flex justify-center items-center py-3 bg-blue-950 text-white font-bold rounded-xl border border-blue-950 hover:bg-white hover:text-blue-950 active:bg-blue-900 active:text-white shadow-lg hover:shadow-blue-900/30 hover:scale-[1.02] transition-all duration-200">
                        ✨ Lihat Novel Wrapped
                    </a>
                    
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
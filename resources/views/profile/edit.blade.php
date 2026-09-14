<x-app-layout>
    <div class="container mx-auto px-4 py-12 max-w-4xl">
        
        <!-- Header Halaman -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Pengaturan Akun</h2>
                <p class="text-gray-500 text-sm mt-1">Kelola informasi profil, keamanan kata sandi, dan akun Novelku Anda.</p>
            </div>
            <!-- Tombol Kembali ke Profil -->
            <a href="/profile" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl shadow-sm hover:bg-gray-50 text-sm transition-all">
                ← Kembali
            </a>
        </div>

        <div class="space-y-8">
            <!-- 1. Form Informasi Profil & Avatar -->
            <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-md border border-gray-100 transition-all duration-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- 2. Form Ganti Password -->
            <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-md border border-gray-100 transition-all duration-200">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- 3. Form Hapus Akun -->
            <div class="p-6 sm:p-10 bg-white rounded-3xl shadow-sm border border-red-100 bg-red-50/10 transition-all duration-200">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
        
    </div>
</x-app-layout>
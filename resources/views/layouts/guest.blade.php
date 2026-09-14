<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Novelku') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Cloudflare Turnstile Script -->
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <!-- Background Baru: Gradient Lembut & Estetik -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tr from-slate-100 via-indigo-50 to-violet-100 relative overflow-hidden">
            
            <!-- Ornamen Dekoratif di Background (Blur Blobs) -->
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-white/80 backdrop-blur-lg shadow-2xl border border-white/50 sm:rounded-3xl flex flex-col items-center">
                
                <!-- 1. AREA LOGO KHUSUS LOGIN & REGISTER -->
                <div class="mb-6 transform hover:scale-105 transition-transform duration-300">
                    <a href="/">
                        <!-- Ganti dengan path logo khusus Auth-mu, misal ukuran lebih besar atau versi icon saja -->
                        <img src="{{ asset('storage/images/logo-auth.png') }}" alt="Logo Auth" class="w-55 h-24 object-contain drop-shadow-md">
                       
                    </a>
                </div>

                <!-- Judul Penyambut Ringan -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Selamat Datang Kembali!</h2>
                    <p class="text-sm text-gray-500 mt-1">Masuk untuk melanjutkan petualangan membaca ceritamu.</p>
                </div>

                <!-- Area Form Utama -->
                <div class="w-full">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
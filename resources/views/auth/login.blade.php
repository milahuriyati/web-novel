<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Widget CAPTCHA Cloudflare -->
        <div class="cf-turnstile mt-4" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>

        <!-- Menampilkan pesan error jika user lupa memverifikasi atau verifikasi gagal -->
        @error('cf-turnstile-response')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror

        <div class="flex items-center justify-start mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Tambahkan mt-5 di awal class tombol -->
        <x-primary-button class="mt-5 w-full inline-flex justify-center items-center py-3 bg-blue-950 text-white font-bold rounded-xl border border-blue-950 hover:bg-white hover:text-blue-950 active:bg-blue-900 active:text-white shadow-lg hover:shadow-blue-900/30 hover:scale-[1.02] transition-all duration-200">
            {{ __('Log in') }}
        </x-primary-button>
        
    </form>
</x-guest-layout>

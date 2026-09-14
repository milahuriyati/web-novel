<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Widget CAPTCHA Cloudflare -->
        <div class="cf-turnstile mt-4" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>

        <!-- Menampilkan pesan error jika user lupa memverifikasi atau verifikasi gagal -->
        @error('cf-turnstile-response')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror

        <div class="flex items-center justify-start mt-4">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>            
        </div>

        <!-- Tambahkan mt-5 dan sesuaikan gradient agar serasi dengan tombol Login -->
        <x-primary-button class="mt-5 w-full inline-flex justify-center items-center py-3 bg-blue-950 text-white font-bold rounded-xl border border-blue-950 hover:bg-white hover:text-blue-950 active:bg-blue-900 active:text-white shadow-lg hover:shadow-blue-900/30 hover:scale-[1.02] transition-all duration-200">
            {{ __('Register') }}
        </x-primary-button>
    </form>
</x-guest-layout>

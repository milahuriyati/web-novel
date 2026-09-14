<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- 1. LOGO APLIKASI -> selalu mengarah ke Welcome -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="font-extrabold text-xl bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                        Novelku📚
                    </a>
                </div>

                <!-- 2. MENU LINK UNTUK DESKTOP (Layar Besar) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!-- Welcome tetap tampil untuk SEMUA orang, login ataupun tidak -->
                    <x-nav-link href="{{ route('welcome') }}" :active="request()->routeIs('welcome')">
                        {{ __('Welcome') }}
                    </x-nav-link>

                    @auth
                        <!-- Memanggil nama rute yang benar sesuai web.php yaitu 'frontend.books.index' -->
                        <x-nav-link href="{{ route('frontend.books.index') }}" :active="request()->routeIs('frontend.books.index')">
                            {{ __('Jelajahi Buku') }}
                        </x-nav-link>

                        <!-- KONDISI MENU KETIGA BERDASARKAN ROLE (Deteksi aktif diubah ke 'dashboard') -->
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Halaman Admin') }}
                            </x-nav-link>

                        @elseif(Auth::user()->role === 'penulis')
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard Penulis') }}
                            </x-nav-link>

                        @elseif(Auth::user()->role === 'pembaca')
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard Pembaca') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- 3. SISI KANAN: Profile Dropdown (login) atau Login/Register (guest) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-content font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <!-- Menampilkan Nama & Badge Role -->
                                <div class="flex items-center gap-2">
                                    <span>{{ Auth::user()->name }}</span>
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-gray-100 text-gray-600 capitalize">
                                        {{ Auth::user()->role }}
                                    </span>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link href="{{ route('profile.index') }}">
                                {{ __('Profile Saya') }}
                            </x-dropdown-link>

                            <!-- Tombol Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- PUBLIC: hanya Login / Register -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            {{ __('Log in') }}
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 transition">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Tombol Hamburger (Khusus Tampilan Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
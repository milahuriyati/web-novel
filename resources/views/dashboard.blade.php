<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <p class="mb-4 text-lg">Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
                    <hr class="mb-6">

                    {{-- Changed @elseif to @if --}}
                    @if (Auth::user()->role === 'penulis')
                        <h3 class="text-xl font-bold text-blue-600 mb-4">✍️ Panel Penulis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <a href="{{ route('books.create') }}"
                                class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 text-center">
                                <span class="font-bold text-blue-700">+ Tulis Buku Baru</span>
                            </a>
                            <div class="block p-4 bg-gray-50 border border-gray-200 rounded-lg text-center">
                                <span class="font-bold text-gray-700">Total Buku Kamu: {{ $myBooks->count() }}</span>
                            </div>
                        </div>

                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Daftar Buku Karya Saya</h4>
                        <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-700 tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">Cover</th> <!-- Kolom Cover Baru -->
                                        <th class="px-6 py-3">Judul Buku</th>
                                        <th class="px-6 py-3">Kategori</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse($myBooks as $book)
                                        <tr class="hover:bg-gray-50">
                                            <!-- Menampilkan Gambar Cover -->
                                            <td class="px-6 py-4">
                                                @if ($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                                        alt="Cover"
                                                        class="w-12 h-16 object-cover rounded shadow-sm border border-gray-200">
                                                @else
                                                    <div
                                                        class="w-12 h-16 bg-gray-100 rounded flex items-center justify-center text-[10px] text-gray-400 border border-gray-200 text-center p-1">
                                                        No Cover
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 font-medium text-gray-900 truncate max-w-xs">
                                                {{ $book->title }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $book->category->name ?? 'Uncategorized' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($book->status === 'published')
                                                    <span
                                                        class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Published</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Draft</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 space-x-2">
                                                <a href="{{ route('chapters.index', $book->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 font-semibold">Kelola
                                                    Bab</a>
                                                <a href="{{ route('books.edit', $book->id) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 font-semibold">Edit</a>
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus buku ini beserta seluruh babnya?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <!-- Perhatikan colspan diubah jadi 5 karena kolom bertambah -->
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                                Kamu belum menulis buku apapun. Yuk mulai menulis!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Bab: ') }} <span class="text-blue-600">{{ $book->title }}</span>
            </h2>
            <a href="/dashboard" class="text-gray-500 hover:text-gray-800 font-semibold text-sm">&larr; Kembali ke
                Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12">
        @if (session('success'))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-sm">
                    <span class="block sm:inline font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header Aksi -->
            <div class="mb-6 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-700">Daftar Isi ({{ $chapters->count() }} Bab)</h3>
                <!-- Tombol ini masih statis, nanti kita hidupkan -->
                <a href="{{ route('chapters.create', $book->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                    + Tambah Bab Baru
                </a>
            </div>

            <!-- Tabel Daftar Bab -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-700 tracking-wider">
                        <tr>
                            <th class="px-6 py-3 w-24">Bab Ke-</th>
                            <th class="px-6 py-3">Judul Bab</th>
                            <th class="px-6 py-3">Tgl Dibuat</th>
                            <th class="px-6 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($chapters as $chapter)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $chapter->chapter_number }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $chapter->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $chapter->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('chapters.edit', $chapter->id) }}"
                                        class="text-yellow-600 hover:text-yellow-900 font-semibold">Edit</a>
                                    <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold" onclick="return confirm('Apakah Anda yakin ingin menghapus bab ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Buku ini belum memiliki bab cerita. Silakan tambah bab pertama!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

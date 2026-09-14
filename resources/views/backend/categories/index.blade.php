<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kategori Buku') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition text-sm">
                ➕ Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50 text-gray-600 font-semibold">
                            <th class="py-3 px-4 w-16">No</th>
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-gray-600">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-medium text-gray-800">{{ $category->name }}</td>
                                <td class="py-3 px-4 text-center flex justify-center items-center gap-3">
                                    {{-- Tombol Edit Ke Halaman Edit --}}
                                    <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-xs bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200 transition">
                                        Edit
                                    </a>

                                    {{-- Form/Tombol Hapus Paksa Kategori --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-xs bg-red-50 px-3 py-1.5 rounded-lg border border-red-200 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-8 text-gray-500 italic">Belum ada kategori yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
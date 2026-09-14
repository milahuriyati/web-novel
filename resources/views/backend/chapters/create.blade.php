<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Bab Baru: ') }} <span class="text-blue-600">{{ $book->title }}</span>
        </h2>
    </x-slot>

    <!-- PANGGIL SCRIPT CKEDITOR 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <!-- CSS Tambahan agar Editornya Bagus dan Tinggi -->
    <style>
        .ck-editor__editable {
            min-height: 400px;
        }
        /* 3. FIX HEADING & FORMATTING DI DALAM EDITOR */
        .ck-editor__editable h2 {
            font-size: 1.5rem !important; /* Ukuran Heading 1 (h2 di CKEditor) */
            font-weight: 700 !important;
            margin-top: 1.5rem !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        .ck-editor__editable h3 {
            font-size: 1.25rem !important; /* Ukuran Heading 2 (h3 di CKEditor) */
            font-weight: 700 !important;
            margin-top: 1.25rem !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        .ck-editor__editable h4 {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            margin-top: 1rem !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        /* Beri jarak antar paragraf cerita agar tidak menempel rapat */
        .ck-editor__editable p {
            margin-bottom: 1rem !important;
            line-height: 1.75 !important;
        }

        /* Merapikan tampilan list (bulleted/numbered) jika dipakai */
        .ck-editor__editable ul {
            list-style-type: disc !important;
            padding-left: 2rem !important;
            margin-bottom: 1rem !important;
        }

        .ck-editor__editable ol {
            list-style-type: decimal !important;
            padding-left: 2rem !important;
            margin-bottom: 1rem !important;
        }
        .ck-reset_all * {
            box-sizing: border-index !important;
            border-style: none !important; /* Reset border bawaan tailwind di tombol */
        }
        .ck.ck-button {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 5px !important;
        }
        .ck.ck-toolbar .ck-toolbar__items {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
        }
        .ck.ck-icon {
            display: inline-block !important;
            vertical-align: middle !important;
            width: 14px !important;
            height: 14px !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('chapters.store', $book->id) }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="md:col-span-1">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Bab Ke-</label>
                                <input type="number" name="chapter_number" value="{{ $nextChapterNumber }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Bab</label>
                                <input type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required placeholder="Misalnya: Pertemuan Dua Dunia...">
                            </div>
                        </div>

                        <!-- Area Teks Utama -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Isi Cerita & Ilustrasi</label>
                            <!-- ID 'editor' digunakan untuk memicu CKEditor -->
                            <textarea id="editor" name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" placeholder="Mulai ketik ceritamu di sini..."></textarea>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow focus:outline-none focus:shadow-outline">
                                Publish Bab Ini
                            </button>
                            <a href="{{ route('chapters.index', $book->id) }}" class="text-gray-500 hover:text-gray-800 font-semibold">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT UNTUK MENGAKTIFKAN EDITOR DAN KONEKSI UPLOAD -->
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // Konfigurasi plugin upload gambar bawaan CKEditor
                ckfinder: {
                    uploadUrl: "{{ route('chapters.upload_image') }}"
                },
                // Toolbar menu yang disediakan
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 
                    'imageUpload', 'blockQuote', 'insertTable', 'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>
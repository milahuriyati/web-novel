<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bab: ') }} <span class="text-blue-600">{{ $chapter->title }}</span>
        </h2>
    </x-slot>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <style>
        .ck-editor__editable { min-height: 400px; }
        .ck-reset_all * { box-sizing: border-box !important; border-style: none !important; }
        .ck.ck-button { display: flex !important; align-items: center !important; justify-content: center !important; padding: 5px !important; }
        .ck.ck-toolbar .ck-toolbar__items { display: flex !important; flex-wrap: wrap !important; align-items: center !important; }
        .ck.ck-icon { display: inline-block !important; vertical-align: middle !important; width: 14px !important; height: 14px !important; }
        .ck-editor__editable h2 { font-size: 1.5rem !important; font-weight: 700 !important; margin-top: 1.5rem !important; margin-bottom: 0.5rem !important; display: block !important; }
        .ck-editor__editable h3 { font-size: 1.25rem !important; font-weight: 700 !important; margin-top: 1.25rem !important; margin-bottom: 0.5rem !important; display: block !important; }
        .ck-editor__editable p { margin-bottom: 1rem !important; line-height: 1.75 !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    <!-- Gunakan method PUT untuk proses update -->
                    <form action="{{ route('chapters.update', $chapter->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="md:col-span-1">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Bab Ke-</label>
                                <input type="number" name="chapter_number" value="{{ $chapter->chapter_number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            
                            <div class="md:col-span-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Judul Bab</label>
                                <input type="text" name="title" value="{{ $chapter->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Isi Cerita & Ilustrasi</label>
                            <!-- Teks lama dimasukkan di antara tag textarea -->
                            <textarea id="editor" name="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">{!! $chapter->content !!}</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded shadow focus:outline-none focus:shadow-outline">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('chapters.index', $book->id) }}" class="text-gray-500 hover:text-gray-800 font-semibold">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: { uploadUrl: "{{ route('chapters.upload_image') }}" },
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'imageUpload', 'blockQuote', 'undo', 'redo' ]
            })
            .catch(error => { console.error(error); });
    </script>
</x-app-layout>
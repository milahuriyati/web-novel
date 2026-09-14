<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Chapter;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $book = Book::findOrFail($id);
        $chapters = $book->chapters()->orderBy('chapter_number', 'asc')->get();
        
        return view('backend.chapters.index', compact('book', 'chapters'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $book = Book::findOrFail($id);
        $lastChapter = $book->chapters()->orderBy('chapter_number', 'desc')->first();
        $nextChapterNumber = $lastChapter ? $lastChapter->chapter_number + 1 : 1;
        
        return view('backend.chapters.create', compact('book', 'nextChapterNumber'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
            'content' => 'required|string',
        ]);

        $book->chapters()->create([
            'title' => $validated['title'],
            'chapter_number' => $validated['chapter_number'],
            'content' => $validated['content'],
        ]);
        return redirect()->route('chapters.index', $book->id)->with('success', 'Bab baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $book = $chapter->book; 
        
        return view('backend.chapters.edit', compact('chapter', 'book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $chapter = Chapter::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'chapter_number' => 'required|integer|min:1',
            'content' => 'required|string',
        ]);
        $chapter->update([
            'title' => $validated['title'],
            'chapter_number' => $validated['chapter_number'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('chapters.index', $chapter->book_id)->with('success', 'Bab berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $bookId = $chapter->book_id;
        
        // Hapus bab dari database
        $chapter->delete();

        return redirect()->route('chapters.index', $bookId)->with('success', 'Bab berhasil dihapus!');
    }

    public function uploadImage(Request $request)
    {
        
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            
            
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            
            
            $request->file('upload')->storeAs('chapters_illustrations', $fileName, 'public');

            
            $url = asset('storage/chapters_illustrations/' . $fileName);
            
            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => $url
            ]);
        }
    }
}

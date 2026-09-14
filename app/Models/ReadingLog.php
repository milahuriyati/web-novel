<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingLog extends Model
{
    use HasFactory;

    // Mengizinkan pengisian data massal (Mass Assignment)
    protected $fillable = [
        'user_id',
        'book_id',
        'chapter_id',
        'read_duration_minutes',
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Book
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Relasi ke tabel Chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $guarded = ['id'];

    // Relasi: Bab ini adalah bagian dari satu Buku
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('user', 'replies.user')->latest();;
    }

    // Relasi: Buku ini punya banyak Like
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

}

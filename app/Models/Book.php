<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Book extends Model
{
    use Hasfactory, SoftDeletes; // Tambahkan ini agar bisa soft delete

    protected $guarded = ['id']; // Mengizinkan semua kolom diisi kecuali ID

    // Relasi: Buku ini dimiliki oleh satu Penulis (User)
    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi: Buku ini memiliki satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Tanpa Kategori', // Nama default jika kategorinya NULL
            'slug' => 'tanpa-kategori'
        ]);
    }

    // Relasi: Buku ini punya banyak Bab (Chapters)
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Relasi: Buku ini punya banyak Komentar
    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Chapter::class);
    }

    // Mengambil semua likes dari semua chapter yang ada di buku ini
    public function likes()
    {
        return $this->hasManyThrough(Like::class, Chapter::class);
    }
    public function lastRead()
    {
        return $this->hasOne(ReadingHistory::class)->where('user_id', Auth::id());
    }   
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes()->where('user_id', $user->id)->exists();
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    // Helper untuk mengecek apakah user tertentu sudah memfavoritkan buku ini
    public function isFavoritedBy(?User $user)
    {
        if (!$user) return false;
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    // Relasi: Satu kategori bisa dipakai oleh banyak Buku
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
}

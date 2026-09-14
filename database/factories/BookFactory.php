<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kamus = [
            'dan', 'di', 'yang', 'untuk', 'pada', 'ke', 'dari', 'karena', 'cinta', 'rahasia', 
            'takdir', 'hutan', 'kelam', 'pangeran', 'bayangan', 'waktu', 'bintang', 'hati', 
            'rindu', 'dendam', 'pedang', 'sihir', 'langit', 'bumi', 'cahaya', 'perjalanan', 
            'ilusi', 'mimpi', 'jiwa', 'putri', 'kerajaan', 'naga', 'pahlawan', 'kegelapan', 
            'keabadian', 'misteri', 'darah', 'senja', 'kembalinya', 'jejak', 'kota', 'tua', 
            'kampus', 'jakarta', 'terlarang', 'luka', 'pengembara', 'sebuah', 'kisah', 
            'tentang', 'perjuangan', 'pengorbanan', 'tengah', 'kerasnya', 'kehidupan', 
            'karakter', 'utama', 'harus', 'menemukan', 'jalan', 'keluarnya', 'sendiri', 
            'tersimpan', 'rapi', 'selama', 'puluhan', 'tahun', 'ketika', 'kebenaran', 
            'mulai', 'terungkap', 'tidak', 'ada', 'satu', 'pun', 'aman', 'pertemuan', 
            'sengaja', 'mengubah', 'segalanya', 'akankah', 'menyatukan', 'mereka', 
            'justru', 'memisahkan', 'selamanya'
        ];
        $titleWords = $this->faker->randomElements($kamus, $this->faker->numberBetween(3, 5));
        $title = ucwords(implode(' ', $titleWords));
        $descWords = $this->faker->randomElements($kamus, $this->faker->numberBetween(30, 50));
        $description = ucfirst(implode(' ', $descWords)) . '.'; // Membuat sinopsis random 30-50 kata
    
        return [
            'user_id' => \App\Models\User::factory(), // Otomatis bikin user penulis baru
            'category_id' => \App\Models\Category::inRandomOrder()->first()?->id ?? 1, // Pilih kategori random
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'description' => $description,
            'cover_image' => null, // Kita kosongkan dulu sementara
            'status' => $this->faker->randomElement(['draft', 'published']),
        ];
    }
}

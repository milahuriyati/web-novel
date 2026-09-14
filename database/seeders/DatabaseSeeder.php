<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Novelku',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'), // password-nya: password
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Penulis Novel',
            'email' => 'penulis@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'penulis',
        ]);

        User::factory()->create([
            'name' => 'Pembaca Novel',
            'email' => 'pembaca@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'pembaca',
        ]);



        $categories = ['Romance', 'Fantasy', 'Sci-Fi', 'Horror', 'Mystery'];
        foreach ($categories as $cat) {
            \App\Models\Category::create([
                'name' => $cat,
                'slug' => \Illuminate\Support\Str::slug($cat),
            ]);
        }
        Book::factory(20)->create();

    }
}

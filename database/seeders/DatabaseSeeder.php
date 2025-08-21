<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder user default
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ✅ Jalankan KategoriSeeder & KontenSeeder
        $this->call([
            KategoriSeeder::class,
            KontenSeeder::class,
        ]);
    }
}

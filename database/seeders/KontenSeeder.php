<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konten;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KontenSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan folder konten_images ada
        Storage::disk('public')->makeDirectory('konten_images');

        // copy satu gambar dummy ke storage/app/public/konten_images
        $source = public_path('images/laravel.png'); // kamu siapkan dulu gambar di public/images/laravel.png
        $destination = 'konten_images/laravel.png';

        if (file_exists($source)) {
            Storage::disk('public')->put($destination, file_get_contents($source));
        }

        // pastikan ada kategori
        $kategori = Kategori::firstOrCreate(['nama' => 'Umum']);

        // buat konten dummy
        Konten::create([
            'judul' => 'Contoh Konten Seeder',
            'isi' => 'Ini adalah contoh konten hasil seeder dengan gambar dummy.',
            'kategori_id' => $kategori->id,
            'gambar' => $destination, // simpan path ke DB
        ]);
    }
}

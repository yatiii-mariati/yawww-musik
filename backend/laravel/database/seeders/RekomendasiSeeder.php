<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rekomendasi;

class RekomendasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Shape of You',
                'artis' => 'Ed Sheeran',
                'deskripsi' => 'Lagu pop romantis yang easy listening',
            ],
            [
                'judul' => 'Bohemian Rhapsody',
                'artis' => 'Queen',
                'deskripsi' => 'Lagu rock klasik sepanjang masa',
            ],
            [
                'judul' => 'Fly Me to the Moon',
                'artis' => 'Frank Sinatra',
                'deskripsi' => 'Jazz klasik bernuansa romantis',
            ],
            [
                'judul' => 'Blinding Lights',
                'artis' => 'The Weeknd',
                'deskripsi' => 'Pop modern dengan nuansa retro',
            ],
        ];

        foreach ($data as $item) {
            Rekomendasi::create($item);
        }
    }
}

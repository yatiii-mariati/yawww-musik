<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Album;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            [
                'artist_id'    => 1, // Payung Teduh
                'title'        => 'Payung Teduh',
                'release_year' => 2010,
            ],
            [
                'artist_id'    => 2, // Pamungkas
                'title'        => 'Walk the Talk',
                'release_year' => 2018,
            ],
            [
                'artist_id'    => 3, // Pamungkas
                'title'        => 'Monolog',
                'release_year' => 2018,
            ],
        ];

        foreach ($albums as $album) {
            Album::create($album);
        }
    }
}

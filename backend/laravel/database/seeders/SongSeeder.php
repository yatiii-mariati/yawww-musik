<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Song;

class SongSeeder extends Seeder
{
    public function run(): void
    {
        $songs = [
            [
                'album_id'   => 1,
                'title'      => 'Angin',
                'duration'   => 281,
                'audio_path' => 'songs/angin.mp3',
            ],
            [
                'album_id'   => 2,
                'title'      => 'Untuk Perempuan Yang sedang Dalam Pelukan',
                'duration'   => 250,
                'audio_path' => 'songs/payung.mp3',
            ],
            [
                'album_id'   => 3,
                'title'      => 'Monolog',
                'duration'   => 230,
                'audio_path' => 'songs/monolog.mp3',
            ],
        ];

        foreach ($songs as $song) {
            Song::create($song);
        }
    }
}

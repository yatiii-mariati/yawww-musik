<?php

namespace Database\Seeders;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artists = [
            ['name' => 'Dewa 19'],
            ['name' => 'Payung Teduh'],
            ['name' => 'Pamungkas'],
        ];

        foreach ($artists as $artist) {
            Artist::create($artist);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

    protected $fillable = [
        'song_id',
        'judul',
        'artis',
        'photo',
        'deskripsi',
    ];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}

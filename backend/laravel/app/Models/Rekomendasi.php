<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $table = 'rekomendasi';

  protected $fillable = [
    'judul',
    'artis',
    'deskripsi'
];

    /**
     * RELASI KE SONG
     */
    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class);
    }
}

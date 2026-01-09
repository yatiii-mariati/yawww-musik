<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property Artist $artist
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Song> $songs
 */
class Album extends Model
{
    protected $fillable = [
        'title',
        'artist_id',
        'release_year',
        'cover'
    ];

    /**
     * @return BelongsTo
     */
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    /**
     * @return HasMany
     */
    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover
            ? asset('storage/' . $this->cover)
            : null;
    }
}

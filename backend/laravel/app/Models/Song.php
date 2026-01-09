<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'genre_id',
        'title',
        'duration',
        'audio_path'
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Rekomendasi::class);
    }

    /**
     * RELATION: SONG → PLAYLIST
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
            ->withTimestamps();
    }

    protected $appends = ['audio_url'];

    public function getAudioUrlAttribute()
    {
        return asset('storage/' . $this->audio_path);
    }
}

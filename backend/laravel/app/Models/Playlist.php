<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Song> $songs
 */
class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    /**
     * @return BelongsToMany
     */
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_song')
            ->withTimestamps();
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

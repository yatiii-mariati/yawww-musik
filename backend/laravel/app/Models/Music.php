<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'artist',
        'file',
        'cover',
    ];

    /* =========================
     |  RELATIONSHIPS
     ========================= */

    /**
     * Music bisa difavoritkan banyak user
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['name', 'photo'];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return asset('storage/' . $this->photo);
    }

    public function albums()
{
    return $this->hasMany(\App\Models\Album::class);
}

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{
    protected $fillable = ['place_id', 'path'];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

   
    public function getUrlAttribute(): string
    {
        return filter_var($this->path, FILTER_VALIDATE_URL)
            ? $this->path
            : asset(ltrim($this->path, '/'));
    }
}

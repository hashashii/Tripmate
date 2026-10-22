<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    // Fields that can be saved through Laravel
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'distance_km',
        'image',
        'latitude',
        'longitude',
        'facilities',
        'safety_info',
        'opening_hours',
        'entrance_fee',
        'accessibility',
        'travel_tips',
    ];

    // A place belongs to one category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // A place can have multiple images
    public function images()
    {
        return $this->hasMany(PlaceImage::class)->orderBy('id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

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
    ];

    // Place එකක් අයිති වෙන්නේ එක Category එකකට
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Category එකකට Places ගොඩක් තියෙන්න පුළුවන්
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}

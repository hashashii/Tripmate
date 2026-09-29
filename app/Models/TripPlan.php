<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_name',
        'visit_date',
        'selected_places',
    ];

    // Selected places list එක Array ekak විදියට auto convert කරන්න
    protected $casts = [
        'selected_places' => 'array',
    ];

    // Trip Plan එක අයිති User ට
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

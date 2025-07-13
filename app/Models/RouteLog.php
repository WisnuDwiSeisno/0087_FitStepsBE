<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'challenge_id', 'date', 'path', 'distance_km', 'duration_min', 'avg_speed_kmh'];

    protected $casts = [
        'path' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'target_steps', 'duration_days', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participations()
    {
        return $this->hasMany(ChallengeParticipation::class);
    }

    public function routeLogs()
    {
        return $this->hasMany(RouteLog::class);
    }
}


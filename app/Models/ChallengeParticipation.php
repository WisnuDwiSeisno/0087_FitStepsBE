<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChallengeParticipation extends Model
{
    use HasFactory;

    protected $fillable = ['challenge_id', 'user_id', 'progress_steps', 'status', 'start_date', 'completed_at'];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


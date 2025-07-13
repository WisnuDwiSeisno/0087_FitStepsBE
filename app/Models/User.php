<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    // JWT Methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Relasi dengan tabel lain
    public function challengesCreated()
    {
        return $this->hasMany(Challenge::class, 'created_by');
    }

    public function participations()
    {
        return $this->hasMany(ChallengeParticipation::class);
    }

    public function steps()
    {
        return $this->hasMany(StepsLog::class);
    }

    public function routes()
    {
        return $this->hasMany(RouteLog::class);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class, 'mentor_id');
    }
}

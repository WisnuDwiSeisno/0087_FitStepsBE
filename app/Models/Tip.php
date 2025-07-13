<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'mentor_id'];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tip;

Tip::create([
    'title' => 'Tips Jaga Stamina',
    'content' => 'Minum air cukup dan pemanasan sebelum berlari.',
    'mentor_id' => 1,
]);

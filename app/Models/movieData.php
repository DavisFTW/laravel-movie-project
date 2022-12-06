<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class movieData extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
    ];

    protected $attributes = [
        'active' => 1,
    ];
    public $timestamps = true;
}
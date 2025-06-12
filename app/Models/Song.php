<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $table = 'songs';
    protected $fillable = [
        'title',
        'artist',
        'release_date',
        'lyrics',
        'genre',
        'duration'
    ];
}

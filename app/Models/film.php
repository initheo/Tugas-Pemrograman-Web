<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class film extends Model
{
     protected $table = 'films';
     protected $fillable = [
         'judul', 
         'sutradara', 
         'genere', 
         'tanggal_rilis', 
         'sinopsis'
     ];
}

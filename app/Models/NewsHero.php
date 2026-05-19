<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsHero extends Model
{
    protected $fillable = [
        'bg_image',
        'heading',
        'description',
    ];
}

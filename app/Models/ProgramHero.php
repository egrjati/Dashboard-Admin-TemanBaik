<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramHero extends Model
{
    protected $table = 'program_hero';

    protected $fillable = [
        'title',
        'title_highlight',
        'description',
        'image',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramCard extends Model
{
    protected $table = 'program_cards';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'order',
    ];
}

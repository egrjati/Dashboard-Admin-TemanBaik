<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPageHero extends Model
{
    protected $table = 'program_page_heroes';

    protected $fillable = [
        'program_card_id',
        'bg_image',
        'heading',
        'heading_highlight',
        'description',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramItem extends Model
{
    protected $table = 'program_items';

    protected $fillable = [
        'program_card_id',
        'title',
        'description',
        'image',
        'order',
    ];
}

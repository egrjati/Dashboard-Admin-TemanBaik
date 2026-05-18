<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramPageCta extends Model
{
    protected $table = 'program_page_ctas';

    protected $fillable = [
        'program_card_id',
        'bg_image',
        'heading',
        'description',
    ];
}

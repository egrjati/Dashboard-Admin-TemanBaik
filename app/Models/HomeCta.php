<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCta extends Model
{
    protected $table = 'home_cta';

    protected $fillable = [
        'heading_before',
        'heading_highlight',
        'heading_after',
        'body',
        'button_label',
        'button_href',
        'bg_image',
        'cartoon_image',
    ];
}

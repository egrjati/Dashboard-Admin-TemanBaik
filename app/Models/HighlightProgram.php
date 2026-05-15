<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HighlightProgram extends Model
{
    protected $fillable = [
        'label',
        'desc',
        'image',
        'href',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

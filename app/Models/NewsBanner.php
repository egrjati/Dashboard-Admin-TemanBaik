<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsBanner extends Model
{
    protected $fillable = [
        'image',
        'link',
        'alt',
    ];
}

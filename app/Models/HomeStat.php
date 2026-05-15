<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeStat extends Model
{
    protected $fillable = [
        'key',
        'value',
        'label',
        'icon',
        'description',
        'order',
    ];
}

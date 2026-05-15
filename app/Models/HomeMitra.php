<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeMitra extends Model
{
    protected $table = 'home_partners';

    protected $fillable = ['image', 'order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}

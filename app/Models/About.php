<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'about';

    protected $fillable = [
        'image',
        'title',
        'description',
        'story_title',
        'story_description',
        'story_image_1',
        'story_image_2',
        'story_image_3',
    ];
}

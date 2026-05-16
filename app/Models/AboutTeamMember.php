<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutTeamMember extends Model
{
    protected $fillable = ['name', 'position', 'photo', 'order'];
}

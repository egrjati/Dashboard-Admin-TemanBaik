<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProgramCard extends Model
{
    protected $table = 'program_cards';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'order',
    ];

    public function pageHero(): HasOne
    {
        return $this->hasOne(ProgramPageHero::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProgramItem::class)->orderBy('order');
    }

    public function pageCta(): HasOne
    {
        return $this->hasOne(ProgramPageCta::class);
    }
}

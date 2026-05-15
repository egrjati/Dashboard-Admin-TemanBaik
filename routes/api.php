<?php

use App\Models\HeroSlider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/hero-sliders', function () {
    $sliders = HeroSlider::where('is_active', true)
        ->orderBy('order')
        ->get(['id', 'title', 'image', 'link']);

    return response()->json(
        $sliders->map(fn($s) => [
            'id'    => $s->id,
            'title' => $s->title,
            'image' => Storage::disk('public')->url($s->image),
            'link'  => $s->link,
        ])
    );
});

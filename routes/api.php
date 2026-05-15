<?php

use App\Models\HeroSlider;
use App\Models\HomeStat;
use App\Models\HomeTestimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/home-testimonials', function () {
    return response()->json(
        HomeTestimonial::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'name', 'role', 'location', 'quote'])
    );
});

Route::get('/home-stats', function () {
    return response()->json(
        HomeStat::orderBy('order')->get(['key', 'value', 'label', 'icon', 'description'])
    );
});

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

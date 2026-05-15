<?php

use App\Models\HeroSlider;
use App\Models\HomeStat;
use App\Models\HomeTestimonial;
use App\Models\HighlightProgram;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/highlight-programs', function () {
    return response()->json(
        HighlightProgram::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'label', 'desc', 'image', 'href'])
            ->map(fn($p) => [
                'id'    => $p->id,
                'label' => $p->label,
                'desc'  => $p->desc,
                'image' => $p->image ? Storage::disk('public')->url($p->image) : null,
                'href'  => $p->href,
            ])
    );
});

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

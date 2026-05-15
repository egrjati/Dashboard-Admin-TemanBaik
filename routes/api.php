<?php

use App\Models\HeroSlider;
use App\Models\HomeStat;
use App\Models\HomeTestimonial;
use App\Models\HighlightProgram;
use App\Models\HomeMitra;
use Illuminate\Support\Facades\Route;

Route::get('/home-partners', function () {
    return response()->json(
        HomeMitra::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'image'])
            ->map(fn($p) => [
                'id'    => $p->id,
                'image' => asset('storage/' . $p->image),
            ])
    );
});

Route::get('/highlight-programs', function () {
    return response()->json(
        HighlightProgram::where('is_active', true)
            ->orderBy('order')
            ->get(['id', 'label', 'desc', 'image', 'href'])
            ->map(fn($p) => [
                'id'    => $p->id,
                'label' => $p->label,
                'desc'  => $p->desc,
                'image' => $p->image ? asset('storage/' . $p->image) : null,
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
            'image' => asset('storage/' . $s->image),
            'link'  => $s->link,
        ])
    );
});

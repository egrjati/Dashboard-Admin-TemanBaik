<?php

use App\Models\About;
use App\Models\AboutTeamMember;
use App\Models\HeroSlider;
use App\Models\HomeStat;
use App\Models\HomeTestimonial;
use App\Models\HighlightProgram;
use App\Models\HomeMitra;
use App\Models\HomeCta;
use Illuminate\Support\Facades\Route;

Route::get('/about', function () {
    $about   = About::first();
    $members = AboutTeamMember::orderBy('order')->get();

    return response()->json([
        'hero' => $about ? [
            'title'       => $about->title,
            'description' => $about->description,
            'image'       => $about->image ? asset('storage/' . $about->image) : null,
        ] : null,
        'story' => $about ? [
            'title'       => $about->story_title,
            'description' => $about->story_description,
            'image_1'     => $about->story_image_1 ? asset('storage/' . $about->story_image_1) : null,
            'image_2'     => $about->story_image_2 ? asset('storage/' . $about->story_image_2) : null,
            'image_3'     => $about->story_image_3 ? asset('storage/' . $about->story_image_3) : null,
        ] : null,
        'team' => $members->map(fn($m) => [
            'id'       => $m->id,
            'name'     => $m->name,
            'position' => $m->position,
            'photo'    => $m->photo ? asset('storage/' . $m->photo) : null,
        ]),
    ]);
});

Route::get('/home-cta', function () {
    $cta = HomeCta::first();
    if (!$cta) return response()->json(null);

    return response()->json([
        'heading_before'    => $cta->heading_before,
        'heading_highlight' => $cta->heading_highlight,
        'heading_after'     => $cta->heading_after,
        'body'              => $cta->body,
        'button_label'      => $cta->button_label,
        'button_href'       => $cta->button_href,
        'bg_image'          => $cta->bg_image    ? asset('storage/' . $cta->bg_image)      : null,
        'cartoon_image'     => $cta->cartoon_image ? asset('storage/' . $cta->cartoon_image) : null,
    ]);
});

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

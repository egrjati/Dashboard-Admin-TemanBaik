<?php

use App\Models\About;
use App\Models\ProgramCard;
use App\Models\ProgramHero;
use App\Models\ProgramPageCta;
use App\Models\ProgramPageHero;
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

Route::get('/program-cards', function () {
    return response()->json(
        ProgramCard::orderBy('order')->get()->map(fn($c) => [
            'id'          => $c->id,
            'name'        => $c->name,
            'slug'        => $c->slug,
            'description' => $c->description,
            'image'       => $c->image ? asset('storage/' . $c->image) : null,
            'icon'        => $c->icon,
            'href'        => '/program/' . $c->slug,
        ])
    );
});

Route::get('/program/{slug}', function (string $slug) {
    $card = ProgramCard::where('slug', $slug)->first();
    if (!$card) return response()->json(null, 404);

    $hero  = ProgramPageHero::where('program_card_id', $card->id)->first();
    $items = $card->items()->get()->map(fn($i) => [
        'id'          => $i->id,
        'title'       => $i->title,
        'description' => $i->description,
        'image'       => $i->image ? asset('storage/' . $i->image) : null,
        'order'       => $i->order,
    ]);
    $cta = ProgramPageCta::where('program_card_id', $card->id)->first();

    return response()->json([
        'name' => $card->name,
        'slug' => $card->slug,
        'hero' => $hero ? [
            'bg_image'          => $hero->bg_image ? asset('storage/' . $hero->bg_image) : null,
            'heading'           => $hero->heading,
            'heading_highlight' => $hero->heading_highlight,
            'description'       => $hero->description,
        ] : null,
        'items' => $items,
        'cta'  => $cta ? [
            'bg_image'    => $cta->bg_image ? asset('storage/' . $cta->bg_image) : null,
            'heading'     => $cta->heading,
            'description' => $cta->description,
        ] : null,
    ]);
});

Route::get('/news-banner', function () {
    $banner = \App\Models\NewsBanner::first();
    if (!$banner || !$banner->image) return response()->json(null);

    return response()->json([
        'image' => asset('storage/' . $banner->image),
        'link'  => $banner->link,
        'alt'   => $banner->alt,
    ]);
});

Route::get('/news-hero', function () {
    $hero = \App\Models\NewsHero::first();
    if (!$hero) return response()->json(null);

    return response()->json([
        'heading'     => $hero->heading,
        'description' => $hero->description,
        'bg_image'    => $hero->bg_image ? asset('storage/' . $hero->bg_image) : null,
    ]);
});

Route::get('/news', function () {
    return response()->json(
        \App\Models\News::where('is_published', true)
            ->orderByDesc('published_at')
            ->get()
            ->map(fn($n) => [
                'id'           => $n->id,
                'title'        => $n->title,
                'excerpt'      => $n->excerpt,
                'category'     => $n->category,
                'image'        => $n->image ? asset('storage/' . $n->image) : null,
                'published_at' => $n->published_at?->format('d M Y'),
                'tier'         => $n->tier,
            ])
    );
});

Route::get('/news/{id}', function (int $id) {
    $news = \App\Models\News::where('id', $id)->where('is_published', true)->first();
    if (!$news) return response()->json(null, 404);

    return response()->json([
        'id'           => $news->id,
        'title'        => $news->title,
        'excerpt'      => $news->excerpt,
        'content'      => $news->content,
        'category'     => $news->category,
        'image'        => $news->image ? asset('storage/' . $news->image) : null,
        'published_at' => $news->published_at?->format('d M Y'),
        'tier'         => $news->tier,
    ]);
});

Route::get('/program-hero', function () {
    $hero = ProgramHero::first();
    if (!$hero) return response()->json(null);

    return response()->json([
        'title'           => $hero->title,
        'title_highlight' => $hero->title_highlight,
        'description'     => $hero->description,
        'image'           => $hero->image ? asset('storage/' . $hero->image) : null,
    ]);
});

<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\HomeStat;
use App\Models\HomeMitra;
use App\Models\HomeCta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $sliders          = HeroSlider::orderBy('order')->get();
        $stats            = HomeStat::orderBy('order')->get();
        $testimonials     = \App\Models\HomeTestimonial::orderBy('order')->get();
        $highlightPrograms = \App\Models\HighlightProgram::orderBy('order')->get();
        $partners          = HomeMitra::orderBy('order')->get();
        $cta               = HomeCta::first();
        return view('admin.markom.home.index', compact('sliders', 'stats', 'testimonials', 'highlightPrograms', 'partners', 'cta'));
    }

    public function updateStats(Request $request)
    {
        $request->validate([
            'stats'              => 'required|array',
            'stats.*.key'        => 'required|string',
            'stats.*.value'      => 'required|string|max:50',
            'stats.*.label'      => 'required|string|max:100',
            'stats.*.icon'       => 'required|in:users,heart,location',
            'stats.*.description'=> 'nullable|string|max:255',
        ]);

        foreach ($request->stats as $item) {
            HomeStat::where('key', $item['key'])->update([
                'value'       => $item['value'],
                'label'       => $item['label'],
                'icon'        => $item['icon'],
                'description' => $item['description'] ?? null,
            ]);
        }

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Data penyebaran berhasil diperbarui.');
    }

    public function updateCta(Request $request)
    {
        $request->validate([
            'heading_before'    => 'required|string|max:100',
            'heading_highlight' => 'required|string|max:100',
            'heading_after'     => 'required|string|max:100',
            'body'              => 'required|string',
            'button_label'      => 'required|string|max:60',
            'button_href'       => 'required|string|max:255',
            'bg_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'cartoon_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $cta  = HomeCta::firstOrCreate([]);
        $data = $request->only(['heading_before', 'heading_highlight', 'heading_after', 'body', 'button_label', 'button_href']);

        if ($request->hasFile('bg_image')) {
            if ($cta->bg_image) Storage::disk('public')->delete($cta->bg_image);
            $data['bg_image'] = $request->file('bg_image')->store('home-cta', 'public');
        }

        if ($request->hasFile('cartoon_image')) {
            if ($cta->cartoon_image) Storage::disk('public')->delete($cta->cartoon_image);
            $data['cartoon_image'] = $request->file('cartoon_image')->store('home-cta', 'public');
        }

        $cta->update($data);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'CTA Relawan berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order' => 'nullable|integer|min:0',
        ]);

        HeroSlider::create([
            'title'     => $request->title,
            'image'     => $request->file('image')->store('hero-sliders', 'public'),
            'link'      => $request->link,
            'order'     => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Slide berhasil ditambahkan.');
    }

    public function update(Request $request, HeroSlider $home)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'title'     => $request->title,
            'link'      => $request->link,
            'order'     => $request->order ?? $home->order,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($home->image);
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }

        $home->update($data);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(HeroSlider $home)
    {
        Storage::disk('public')->delete($home->image);
        $home->delete();

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Slide berhasil dihapus.');
    }
}

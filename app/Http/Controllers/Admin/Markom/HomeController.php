<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('order')->get();
        return view('admin.markom.home.index', compact('sliders'));
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

<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::firstOrCreate([], ['title' => '', 'description' => '', 'image' => '']);
        return view('admin.markom.about.index', compact('about'));
    }

    public function updateHero(Request $request, About $about)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            if ($about->image) Storage::disk('public')->delete($about->image);
            $data['image'] = $request->file('image')->store('about', 'public');
        }

        $about->update($data);

        return redirect()->route('admin.markom.about.index')
            ->with('success', 'Section Hero berhasil diperbarui.');
    }

    public function updateStory(Request $request, About $about)
    {
        $request->validate([
            'story_title'       => 'nullable|string|max:255',
            'story_description' => 'nullable|string',
            'story_image_1'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'story_image_2'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'story_image_3'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = $request->only(['story_title', 'story_description']);

        foreach (['story_image_1', 'story_image_2', 'story_image_3'] as $field) {
            if ($request->hasFile($field)) {
                if ($about->$field) Storage::disk('public')->delete($about->$field);
                $data[$field] = $request->file($field)->store('about', 'public');
            }
        }

        $about->update($data);

        return redirect()->route('admin.markom.about.index')
            ->with('success', 'Section Kisah Kami berhasil diperbarui.');
    }
}

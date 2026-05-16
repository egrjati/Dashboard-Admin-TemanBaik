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
        $hero = About::firstOrCreate([], ['title' => '', 'description' => '', 'image' => '']);
        return view('admin.markom.about.index', compact('hero'));
    }

    public function update(Request $request, About $about)
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
            ->with('success', 'Hero berhasil diperbarui.');
    }
}

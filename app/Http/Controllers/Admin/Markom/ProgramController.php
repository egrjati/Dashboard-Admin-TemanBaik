<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\ProgramCard;
use App\Models\ProgramHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $hero = ProgramHero::firstOrCreate([], [
            'title'           => 'Program',
            'title_highlight' => 'Teman Baik',
            'description'     => 'Temukan layanan zakat & donasi yang mudah, aman, dan terpercaya untuk Anda.',
        ]);

        $cards = ProgramCard::orderBy('order')->get();

        return view('admin.markom.programs.index', compact('hero', 'cards'));
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:100',
            'title_highlight' => 'required|string|max:100',
            'description'     => 'nullable|string|max:500',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $hero = ProgramHero::firstOrCreate([]);
        $data = $request->only(['title', 'title_highlight', 'description']);

        if ($request->hasFile('image')) {
            if ($hero->image) Storage::disk('public')->delete($hero->image);
            $data['image'] = $request->file('image')->store('program-hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.markom.program.index')
            ->with('success', 'Section Hero Program berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'icon'        => 'required|string|max:60',
            'order'       => 'nullable|integer|min:0',
        ]);

        $slug = Str::slug($request->name);
        $base = $slug;
        $i    = 1;
        while (ProgramCard::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $data = [
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'icon'        => $request->icon,
            'order'       => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('program-cards', 'public');
        }

        ProgramCard::create($data);

        return redirect()->route('admin.markom.program.index')
            ->with('success', 'Card program berhasil ditambahkan.');
    }

    public function update(Request $request, ProgramCard $program)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'icon'        => 'required|string|max:60',
            'order'       => 'nullable|integer|min:0',
        ]);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'icon'        => $request->icon,
            'order'       => $request->order ?? $program->order,
        ];

        if ($request->hasFile('image')) {
            if ($program->image) Storage::disk('public')->delete($program->image);
            $data['image'] = $request->file('image')->store('program-cards', 'public');
        }

        $program->update($data);

        return redirect()->route('admin.markom.program.index')
            ->with('success', 'Card program berhasil diperbarui.');
    }

    public function destroy(ProgramCard $program)
    {
        if ($program->image) Storage::disk('public')->delete($program->image);
        $program->delete();

        return redirect()->route('admin.markom.program.index')
            ->with('success', 'Card program berhasil dihapus.');
    }
}

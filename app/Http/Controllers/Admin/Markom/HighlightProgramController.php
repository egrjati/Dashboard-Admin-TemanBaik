<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\HighlightProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightProgramController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label'     => 'required|string|max:100',
            'desc'      => 'required|string|max:500',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'href'      => 'required|string|max:255',
            'order'     => 'nullable|integer|min:0',
        ]);

        HighlightProgram::create([
            'label'     => $request->label,
            'desc'      => $request->desc,
            'image'     => $request->hasFile('image')
                            ? $request->file('image')->store('highlight-programs', 'public')
                            : null,
            'href'      => $request->href,
            'order'     => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Program berhasil ditambahkan.');
    }

    public function update(Request $request, HighlightProgram $highlightProgram)
    {
        $request->validate([
            'label'     => 'required|string|max:100',
            'desc'      => 'required|string|max:500',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'href'      => 'required|string|max:255',
            'order'     => 'nullable|integer|min:0',
        ]);

        $data = [
            'label'     => $request->label,
            'desc'      => $request->desc,
            'href'      => $request->href,
            'order'     => $request->order ?? $highlightProgram->order,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($highlightProgram->image) {
                Storage::disk('public')->delete($highlightProgram->image);
            }
            $data['image'] = $request->file('image')->store('highlight-programs', 'public');
        }

        $highlightProgram->update($data);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(HighlightProgram $highlightProgram)
    {
        if ($highlightProgram->image) {
            Storage::disk('public')->delete($highlightProgram->image);
        }
        $highlightProgram->delete();

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Program berhasil dihapus.');
    }
}

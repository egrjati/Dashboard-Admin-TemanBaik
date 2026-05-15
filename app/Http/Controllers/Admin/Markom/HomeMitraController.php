<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\HomeMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeMitraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order' => 'nullable|integer|min:0',
        ]);

        HomeMitra::create([
            'image'     => $request->file('image')->store('home-partners', 'public'),
            'order'     => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Logo mitra berhasil ditambahkan.');
    }

    public function update(Request $request, HomeMitra $homeMitra)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'order'     => $request->order ?? $homeMitra->order,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($homeMitra->image);
            $data['image'] = $request->file('image')->store('home-partners', 'public');
        }

        $homeMitra->update($data);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Logo mitra berhasil diperbarui.');
    }

    public function destroy(HomeMitra $homeMitra)
    {
        Storage::disk('public')->delete($homeMitra->image);
        $homeMitra->delete();

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Logo mitra berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\AboutTeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutTeamMemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order'    => 'nullable|integer|min:0',
        ]);

        AboutTeamMember::create([
            'name'     => $request->name,
            'position' => $request->position,
            'photo'    => $request->hasFile('photo') ? $request->file('photo')->store('about-team', 'public') : null,
            'order'    => $request->order ?? 0,
        ]);

        return redirect()->route('admin.markom.about.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function update(Request $request, AboutTeamMember $aboutTeamMember)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order'    => 'nullable|integer|min:0',
        ]);

        $data = [
            'name'     => $request->name,
            'position' => $request->position,
            'order'    => $request->order ?? $aboutTeamMember->order,
        ];

        if ($request->hasFile('photo')) {
            if ($aboutTeamMember->photo) Storage::disk('public')->delete($aboutTeamMember->photo);
            $data['photo'] = $request->file('photo')->store('about-team', 'public');
        }

        $aboutTeamMember->update($data);

        return redirect()->route('admin.markom.about.index')
            ->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(AboutTeamMember $aboutTeamMember)
    {
        if ($aboutTeamMember->photo) Storage::disk('public')->delete($aboutTeamMember->photo);
        $aboutTeamMember->delete();

        return redirect()->route('admin.markom.about.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\HomeTestimonial;
use Illuminate\Http\Request;

class HomeTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = HomeTestimonial::orderBy('order')->get();
        return view('admin.markom.home.testimonials', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|in:Donatur,Penerima Manfaat,Mitra',
            'location'  => 'required|string|max:100',
            'quote'     => 'required|string|max:500',
            'order'     => 'nullable|integer|min:0',
        ]);

        HomeTestimonial::create([
            'name'      => $request->name,
            'role'      => $request->role,
            'location'  => $request->location,
            'quote'     => $request->quote,
            'order'     => $request->order ?? 0,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function update(Request $request, HomeTestimonial $testimonial)
    {
        $request->validate([
            'name'      => 'required|string|max:100',
            'role'      => 'required|in:Donatur,Penerima Manfaat,Mitra',
            'location'  => 'required|string|max:100',
            'quote'     => 'required|string|max:500',
            'order'     => 'nullable|integer|min:0',
        ]);

        $testimonial->update([
            'name'      => $request->name,
            'role'      => $request->role,
            'location'  => $request->location,
            'quote'     => $request->quote,
            'order'     => $request->order ?? $testimonial->order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(HomeTestimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.markom.home.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\ProgramCard;
use App\Models\ProgramHero;
use App\Models\ProgramItem;
use App\Models\ProgramPageCta;
use App\Models\ProgramPageHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    // ─── Halaman utama program ────────────────────────────────────────────────

    public function index()
    {
        $hero  = ProgramHero::firstOrCreate([], [
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

    // ─── CRUD card program ────────────────────────────────────────────────────

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

    // ─── Halaman konten program detail ───────────────────────────────────────

    public function showContent(ProgramCard $program)
    {
        $pageHero = $program->pageHero ?? new ProgramPageHero(['program_card_id' => $program->id]);
        $items    = $program->items;
        $pageCta  = $program->pageCta  ?? new ProgramPageCta(['program_card_id' => $program->id]);

        return view('admin.markom.programs.content', compact('program', 'pageHero', 'items', 'pageCta'));
    }

    public function updateHeroContent(Request $request, ProgramCard $program)
    {
        $request->validate([
            'heading'           => 'required|string|max:200',
            'heading_highlight' => 'required|string|max:200',
            'description'       => 'nullable|string|max:1000',
            'bg_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $hero = ProgramPageHero::firstOrCreate(['program_card_id' => $program->id]);
        $data = $request->only(['heading', 'heading_highlight', 'description']);

        if ($request->hasFile('bg_image')) {
            if ($hero->bg_image) Storage::disk('public')->delete($hero->bg_image);
            $data['bg_image'] = $request->file('bg_image')->store('program-page-hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.markom.program.content', $program)
            ->with('success', 'Section Hero berhasil diperbarui.');
    }

    public function storeItem(Request $request, ProgramCard $program)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order'       => 'nullable|integer|min:0',
        ]);

        $data = [
            'program_card_id' => $program->id,
            'title'           => $request->title,
            'description'     => $request->description,
            'order'           => $request->order ?? 0,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('program-items', 'public');
        }

        ProgramItem::create($data);

        return redirect()->route('admin.markom.program.content', $program)
            ->with('success', 'Item program berhasil ditambahkan.');
    }

    public function updateItem(Request $request, ProgramCard $program, ProgramItem $item)
    {
        $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'order'       => 'nullable|integer|min:0',
        ]);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'order'       => $request->order ?? $item->order,
        ];

        if ($request->hasFile('image')) {
            if ($item->image) Storage::disk('public')->delete($item->image);
            $data['image'] = $request->file('image')->store('program-items', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.markom.program.content', $program)
            ->with('success', 'Item program berhasil diperbarui.');
    }

    public function destroyItem(ProgramCard $program, ProgramItem $item)
    {
        if ($item->image) Storage::disk('public')->delete($item->image);
        $item->delete();

        return redirect()->route('admin.markom.program.content', $program)
            ->with('success', 'Item program berhasil dihapus.');
    }

    public function updateCtaContent(Request $request, ProgramCard $program)
    {
        $request->validate([
            'heading'     => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'bg_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $cta  = ProgramPageCta::firstOrCreate(['program_card_id' => $program->id]);
        $data = $request->only(['heading', 'description']);

        if ($request->hasFile('bg_image')) {
            if ($cta->bg_image) Storage::disk('public')->delete($cta->bg_image);
            $data['bg_image'] = $request->file('bg_image')->store('program-page-cta', 'public');
        }

        $cta->update($data);

        return redirect()->route('admin.markom.program.content', $program)
            ->with('success', 'Footer CTA berhasil diperbarui.');
    }
}

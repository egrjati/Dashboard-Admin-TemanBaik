<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsBanner;
use App\Models\NewsHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $hero   = NewsHero::firstOrCreate([], [
            'heading'     => 'Berita & Kabar Terbaru',
            'description' => 'Ikuti perkembangan program, aksi, dan dampak nyata yang kami hadirkan di lapangan.',
        ]);
        $banner = NewsBanner::firstOrCreate([]);
        $news   = News::orderByDesc('published_at')->orderByDesc('created_at')->get();

        return view('admin.markom.news.index', compact('hero', 'banner', 'news'));
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'link'  => 'nullable|url|max:500',
            'alt'   => 'nullable|string|max:200',
        ]);

        $banner = NewsBanner::firstOrCreate([]);
        $data   = $request->only(['link', 'alt']);

        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('news-banner', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Banner iklan berita berhasil diperbarui.');
    }

    public function updateHero(Request $request)
    {
        $request->validate([
            'heading'     => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'bg_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $hero = NewsHero::firstOrCreate([]);
        $data = $request->only(['heading', 'description']);

        if ($request->hasFile('bg_image')) {
            if ($hero->bg_image) Storage::disk('public')->delete($hero->bg_image);
            $data['bg_image'] = $request->file('bg_image')->store('news-hero', 'public');
        }

        $hero->update($data);

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Section Hero berita berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:300',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'category'     => 'required|string|max:100',
            'tier'         => 'required|in:hero,highlight,regular',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'category', 'tier', 'published_at']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'        => 'required|string|max:300',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'nullable|string',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'category'     => 'required|string|max:100',
            'tier'         => 'required|in:hero,highlight,regular',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);

        $data = $request->only(['title', 'excerpt', 'content', 'category', 'tier', 'published_at']);
        $data['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($news->image) Storage::disk('public')->delete($news->image);
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $path = $request->file('file')->store('news-content', 'public');

        return response()->json([
            'location' => Storage::disk('public')->url($path),
        ]);
    }

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

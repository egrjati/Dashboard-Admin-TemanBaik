<?php

namespace App\Http\Controllers\Admin\Markom;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderByDesc('published_at')->orderByDesc('created_at')->get();

        return view('admin.markom.news.index', compact('news'));
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

    public function destroy(News $news)
    {
        if ($news->image) Storage::disk('public')->delete($news->image);
        $news->delete();

        return redirect()->route('admin.markom.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

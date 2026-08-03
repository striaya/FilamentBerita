<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Semua berita, dengan dukungan pencarian ?search=
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $news = News::with(['category', 'author'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('news.index', [
            'news' => $news,
            'search' => $search,
            'pageTitle' => $search ? 'Hasil Pencarian' : 'Semua Berita',
        ]);
    }

    /**
     * Detail berita berdasarkan slug
     */
    public function show(string $slug)
    {
        $newsItem = News::with(['category', 'author.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $latestNews = News::with(['category'])
            ->where('id', '!=', $newsItem->id)
            ->latest()
            ->take(3)
            ->get();

        return view('news.show', compact('newsItem', 'latestNews'));
    }

    /**
     * Berita berdasarkan kategori
     */
    public function category(string $slug)
    {
        $category = NewsCategory::where('slug', $slug)->firstOrFail();

        $news = News::with(['category', 'author'])
            ->where('news_category_id', $category->id)
            ->latest()
            ->paginate(8);

        return view('news.index', [
            'news' => $news,
            'search' => null,
            'category' => $category,
            'pageTitle' => $category->title,
        ]);
    }
}

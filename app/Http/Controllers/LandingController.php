<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Banner;
use App\Models\News;

class LandingController extends Controller
{
    public function index()
    {
        // Banner slider (relasi ke News & Category)
        $banners = Banner::with(['news.category', 'news.author'])->latest()->get();

        // Berita unggulan
        $featuredNews = News::with(['category', 'author'])
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();

        // Berita terbaru
        $latestNews = News::with(['category', 'author'])
            ->latest()
            ->take(4)
            ->get();

        // 5 author teratas beserta jumlah berita
        $topAuthors = Author::withCount('news')
            ->orderByDesc('news_count')
            ->take(5)
            ->get();

        // Berita pilihan / acak
        $randomNews = News::with(['category', 'author'])
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('landing.index', compact(
            'banners',
            'featuredNews',
            'latestNews',
            'topAuthors',
            'randomNews',
        ));
    }
}

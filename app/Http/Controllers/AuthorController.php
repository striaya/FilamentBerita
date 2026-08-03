<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    public function show(string $username)
    {
        $author = Author::with('user')
            ->where('username', $username)
            ->withCount('news')
            ->firstOrFail();

        $news = $author->news()
            ->with('category')
            ->latest()
            ->paginate(8);

        return view('author.show', compact('author', 'news'));
    }
}

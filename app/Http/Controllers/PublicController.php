<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Homepage
    public function homepage()
    {
        $articles = Article::where('is_accepted', true)
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('welcome', compact('articles', 'categories'));
    }

    // Cambio lingua
    public function setLanguage($lang)
    {
        session()->put('locale', $lang);
        return redirect()->back();
    }

    // Ricerca articoli con paginazione
    public function searchArticles(Request $request)
    {
        $query = $request->input('query');

        $articles = Article::where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%");
        })
            ->where('is_accepted', true)
            ->paginate(10); // ✅ paginate() per usare links()

        return view('article.search', compact('articles', 'query'));
    }
}

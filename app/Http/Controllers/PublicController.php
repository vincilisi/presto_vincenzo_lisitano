<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class PublicController extends Controller
{
    public function homepage() {
        $articles = Article::where('is_accepted', true)
                           ->latest()
                           ->take(6)
                           ->get();

        $categories = Category::orderBy('name')->get(); // 🔹 recupera le categorie

        return view('welcome', compact('articles', 'categories'));
    }

    public function setLanguage($lang)
    {
        session()->put('locale', $lang);
        return redirect()->back();
    }
}

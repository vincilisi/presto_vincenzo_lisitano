<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware as ControllersMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    public function create()
    {
        return view('article.create');
    }

    public static function middleware()
    {
        return [
            new ControllersMiddleware('auth', ['only' => ['create']]),
        ];
    }

    public function index()
    {
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->paginate(6);
        return view('article.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    public function byCategory(Category $category){
        {
           $articles = $category->articles->where('is_accepted', true);
           return view('article.byCategory', compact('articles', 'category'));
        }
    }
}

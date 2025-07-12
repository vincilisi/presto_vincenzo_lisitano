<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;    
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    public function create()
    {
        return view('article.create');
    }

    public static function middleware()
    {
        return [
            new Middleware('auth', ['only' => ['create']]),
        ];
    }
}
<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RevisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'homepage'])
->name('homepage');

Route::get('/create/article', [ArticleController::class, 'create'])->name('create.article');

Route::get('/article/index',[ArticleController::class, 'index'])->name('article.index');

Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');


Route::get('/category/{category}', [ArticleController::class, 'byCategory'])->name('byCategory');

Route::get('revisor/index', [RevisorController::class, 'index'])->name('revisor.index');

Route::patch('/accept/{article}', [RevisorController::class, 'accept'])->name('accept');

Route::patch('/reject/{article}', [RevisorController::class, 'reject'])->name('reject');

Route::get('revisor/index', [RevisorController::class, 'index'])->middleware('isRevisor')->name('revisor.index');

Route::get('/revisor/request', [RevisorController::class, 'becomeRevisor'])->middleware('auth')->name('become.revisor');

Route::get('/make/revisor/{user}', [RevisorController::class, 'makeRevisor'])->name('make.revisor');

Route::get('/search/article', [PublicController::class, 'searchArticles'])->name('article.search');

Route::post('/lingua/{lang}',[PublicController::class, 'setLanguage'])->name('setLocale');


use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', function () {
    session()->forget('cart');
    return redirect()->route('cart.index')->with('successMessage', __('ui.checkoutSuccess'));
})->name('cart.checkout');



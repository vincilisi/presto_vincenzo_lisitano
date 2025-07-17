<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $articleId = $request->input('article_id');
        $cart = session('cart', []);
        $cart[] = $articleId;
        session(['cart' => $cart]);

        return redirect()->back()->with('successMessage', __('ui.addedToCart'));
    }

    public function remove(Request $request)
{
    $articleId = $request->input('article_id');
    $cart = session('cart', []);
    $updatedCart = array_filter($cart, fn($id) => $id != $articleId);
    session(['cart' => $updatedCart]);

    return redirect()->route('cart.index')->with('successMessage', __('ui.removedFromCart'));
}

}

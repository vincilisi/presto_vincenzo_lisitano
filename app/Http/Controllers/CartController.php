<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Mostra il contenuto del carrello
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Aggiungi un articolo al carrello
    public function add(Request $request)
    {
        $articleId = $request->input('article_id');
        $cart = session('cart', []);
        $cart[] = $articleId;
        session(['cart' => $cart]);

        return redirect()->back()->with('successMessage', __('ui.addedToCart'));
    }

    // Rimuovi un articolo dal carrello
    public function remove(Request $request)
    {
        $articleId = $request->input('article_id');
        $cart = session('cart', []);
        $updatedCart = array_filter($cart, fn($id) => $id != $articleId);
        session(['cart' => $updatedCart]);

        return redirect()->route('cart.index')->with('successMessage', __('ui.removedFromCart'));
    }

    // Checkout: crea gli ordini e svuota il carrello
    public function checkout(Request $request)
    {
        $user = Auth::user(); // L'IDE ora lo riconosce correttamente

        if (!$user) {
            return redirect()->route('login')->with('error', __('ui.loginRequired'));
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', __('ui.cartEmpty'));
        }

        foreach ($cart as $articleId) {
            Order::create([
                'user_id' => $user->id,
                'article_id' => $articleId,
                'quantity' => 1,
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('successMessage', __('ui.checkoutSuccess'));
    }
}

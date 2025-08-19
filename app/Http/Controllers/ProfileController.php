<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Se hai ordini
        $orders = method_exists($user, 'orders') ? $user->orders()->latest()->get() : [];
        return view('profile.index', compact('user', 'orders'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'address']));
        return back()->with('success', 'Profilo aggiornato con successo!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'image|max:2048']);
        $user = Auth::user();
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }
        return back()->with('success', 'Avatar aggiornato!');
    }

    // --- Metodi settings ---
    public function settings()
    {
        $user = Auth::user();
        return view('setting.index', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email', 'address']));
        return back()->with('success', 'Impostazioni aggiornate!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La password attuale non è corretta.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password aggiornata con successo!');
    }
}

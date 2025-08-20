<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $orders = method_exists($user, 'orders') ? $user->orders()->latest()->get() : [];

        $profileIncomplete = empty($user->name) || empty($user->address);
        $isEditing = $request->has('edit');

        return view('profile.index', compact('user', 'orders', 'profileIncomplete', 'isEditing'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'address']));

        return redirect()
            ->route('profile')
            ->with('success', 'Profilo aggiornato con successo!');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|max:2048']);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
            $user->save();
        }

        return redirect()
            ->route('profile')
            ->with('success', 'Avatar aggiornato!');
    }

    public function settings()
    {
        $user = Auth::user();
        return view('setting.index', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'address']));

        return back()->with('success', 'Impostazioni aggiornate!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La password attuale non è corretta.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Logout automatico
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Password aggiornata con successo! Accedi di nuovo con la nuova password.');
    }
}

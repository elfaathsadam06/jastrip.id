<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        // Redirect berdasarkan role
        return match ($user->role) {
            'admin'        => redirect()->route('admin.dashboard'),
            'owner'        => redirect()->route('owner.dashboard'),
            'transkriptor' => redirect()->route('transkriptor.dashboard'),
            default        => redirect()->route('customer.dashboard'),
        };
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

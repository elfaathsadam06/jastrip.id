<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    protected function redirectTo()
    {
        $role = Auth::user()->role;

        return match ($role) {
            'admin'        => '/admin/dashboard',
            'owner'        => '/owner/dashboard',
            'transkriptor' => '/transkriptor/dashboard',
            'customer'     => '/dashboard',
            default        => '/',
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

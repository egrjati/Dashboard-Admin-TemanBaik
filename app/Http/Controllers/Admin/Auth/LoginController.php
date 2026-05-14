<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
{
    return view('admin.auth.login');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // cek email + pw ke db (return true atau false)
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // cegah session fixation attack
        $request->session()->regenerate();
        //redirect ke halaman yang dituju sebelum kena middleware auth, fallback ke dashboard
        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

public function logout(Request $request)
{
    //  invalidate session + regenerate CSRF token sebelum redirect
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
}

}

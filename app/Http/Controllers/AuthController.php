<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $ref = $request->query('ref');
        return view('auth.register', ['ref' => $ref]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:60',
            'username' => 'required|alpha_dash|min:3|max:30|unique:users,username',
            'email'    => 'required|email|max:120|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ref'      => 'nullable|string',
        ]);

        $referrer = !empty($data['ref']) ? User::where('ref_code', $data['ref'])->first() : null;

        $user = User::create([
            'name'        => $data['name'],
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => $data['password'],
            'ref_code'    => $this->uniqueRefCode(),
            'referred_by' => $referrer?->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Welcome to '.config('app.name').'! Your account is ready.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => 'required|string',   // username or email
            'password' => 'required|string',
        ]);

        $field = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (! Auth::attempt([$field => $data['login'], 'password' => $data['password']], $request->boolean('remember'))) {
            return back()->withInput($request->only('login'))
                ->with('error', 'Those credentials do not match our records.');
        }

        if (Auth::user()->is_banned) {
            Auth::logout();
            return back()->with('error', 'Your account has been suspended.');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function uniqueRefCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (User::where('ref_code', $code)->exists());
        return $code;
    }
}

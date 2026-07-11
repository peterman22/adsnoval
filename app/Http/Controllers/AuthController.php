<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Services\Mailer;
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

        // Welcome email
        Mailer::sendTemplate($user->email, 'welcome', [
            'name'      => $user->name,
            'username'  => $user->username,
            'login_url' => route('dashboard'),
        ]);

        // Optional OTP email verification
        if (Setting::val('require_email_verification', '0') === '1') {
            $this->sendOtp($user);
            $request->session()->put('pending_verify_user', $user->id);
            return redirect()->route('verify.show')->with('success', 'We sent a verification code to your email.');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Welcome to '.config('app.name').'! Your account is ready.');
    }

    /* -------- OTP email verification -------- */
    public function showVerify(Request $request)
    {
        if (! $request->session()->has('pending_verify_user')) {
            return redirect()->route('login');
        }
        return view('auth.verify');
    }

    public function verifyOtp(Request $request)
    {
        $id = $request->session()->get('pending_verify_user');
        $user = $id ? User::find($id) : null;
        if (! $user) return redirect()->route('login');

        $request->validate(['otp' => 'required|string']);

        if ($user->otp_code !== $request->otp || ($user->otp_expires_at && $user->otp_expires_at->isPast())) {
            return back()->with('error', 'Invalid or expired code.');
        }

        $user->update(['email_verified_at' => now(), 'otp_code' => null, 'otp_expires_at' => null]);
        $request->session()->forget('pending_verify_user');
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Email verified — welcome!');
    }

    public function resendOtp(Request $request)
    {
        $id = $request->session()->get('pending_verify_user');
        $user = $id ? User::find($id) : null;
        if ($user) $this->sendOtp($user);
        return back()->with('success', 'A new code has been sent.');
    }

    private function sendOtp(User $user): void
    {
        $otp = (string) random_int(100000, 999999);
        $user->update(['otp_code' => $otp, 'otp_expires_at' => now()->addMinutes(10)]);
        Mailer::sendTemplate($user->email, 'otp', ['name' => $user->name, 'otp' => $otp]);
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

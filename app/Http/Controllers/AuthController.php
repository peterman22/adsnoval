<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Services\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // When email verification is required, DON'T create the account yet.
        // Hold the details in the session and only create the user once the
        // emailed code is confirmed in verifyOtp().
        if (Setting::val('require_email_verification', '0') === '1') {
            $otp = (string) random_int(100000, 999999);
            $request->session()->put('pending_registration', [
                'name'     => $data['name'],
                'username' => $data['username'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']), // stored hashed, never in plain text
                'ref'      => $data['ref'] ?? null,
                'otp'      => $otp,
                'expires'  => now()->addMinutes(10)->timestamp,
            ]);
            Mailer::sendTemplate($data['email'], 'otp', ['name' => $data['name'], 'otp' => $otp]);
            return redirect()->route('verify.show')
                ->with('success', 'We sent a 6-digit verification code to '.$data['email'].'.');
        }

        // No verification required — create and sign in immediately.
        $user = $this->createUser($data, verified: false);
        Mailer::sendTemplate($user->email, 'welcome', [
            'name'      => $user->name,
            'username'  => $user->username,
            'login_url' => route('dashboard'),
        ]);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Welcome to '.config('app.name').'! Your account is ready.');
    }

    /* -------- OTP email verification -------- */
    public function showVerify(Request $request)
    {
        $pending = $request->session()->get('pending_registration');
        if (! $pending) {
            return redirect()->route('register');
        }
        return view('auth.verify', ['email' => $pending['email']]);
    }

    public function verifyOtp(Request $request)
    {
        $pending = $request->session()->get('pending_registration');
        if (! $pending) return redirect()->route('register');

        $request->validate(['otp' => 'required|string']);

        if (now()->timestamp > $pending['expires']) {
            return back()->with('error', 'Your code has expired — tap “Resend code” to get a new one.');
        }
        if (! hash_equals((string) $pending['otp'], trim($request->otp))) {
            return back()->with('error', 'That code is incorrect. Please check your email and try again.');
        }

        // Code confirmed — create the fully verified account now.
        $user = $this->createUser($pending, verified: true);
        Mailer::sendTemplate($user->email, 'welcome', [
            'name'      => $user->name,
            'username'  => $user->username,
            'login_url' => route('dashboard'),
        ]);

        $request->session()->forget('pending_registration');
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', 'Email verified — welcome to '.config('app.name').'!');
    }

    public function resendOtp(Request $request)
    {
        $pending = $request->session()->get('pending_registration');
        if (! $pending) return redirect()->route('register');

        $pending['otp']     = (string) random_int(100000, 999999);
        $pending['expires'] = now()->addMinutes(10)->timestamp;
        $request->session()->put('pending_registration', $pending);

        Mailer::sendTemplate($pending['email'], 'otp', ['name' => $pending['name'], 'otp' => $pending['otp']]);
        return back()->with('success', 'A new code has been sent to '.$pending['email'].'.');
    }

    /**
     * Create a user from validated/pending data. Password may arrive already
     * hashed (from the pending session) or plain (direct signup) — the model's
     * hashed cast leaves an existing hash untouched and hashes a plain value.
     */
    private function createUser(array $data, bool $verified): User
    {
        $referrer = ! empty($data['ref']) ? User::where('ref_code', $data['ref'])->first() : null;

        $user = User::create([
            'name'        => $data['name'],
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => $data['password'],
            'ref_code'    => $this->uniqueRefCode(),
            'referred_by' => $referrer?->id,
        ]);

        if ($verified) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        return $user;
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

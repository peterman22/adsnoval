<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AdminAuthController extends Controller {
    public function showLogin(){ return view('admin.login'); }
    public function login(Request $r){
        $d=$r->validate(['email'=>'required|email','password'=>'required']);
        if(!Auth::guard('admin')->attempt($d,$r->boolean('remember')))
            return back()->with('error','Invalid admin credentials.')->withInput($r->only('email'));
        $r->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }
    public function logout(Request $r){
        Auth::guard('admin')->logout(); $r->session()->invalidate(); $r->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}

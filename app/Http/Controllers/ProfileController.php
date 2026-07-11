<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    public function index(){ return view('account.index',['user'=>auth()->user()]); }

    public function updateProfile(Request $r){
        $user=auth()->user();
        $d=$r->validate([
            'name'=>'required|string|max:60',
            'email'=>'required|email|max:120|unique:users,email,'.$user->id,
        ]);
        $user->update($d);
        return back()->with('success','Profile updated.');
    }

    public function updatePassword(Request $r){
        $d=$r->validate([
            'current_password'=>'required',
            'password'=>'required|min:6|confirmed',
        ]);
        $user=auth()->user();
        if(!Hash::check($d['current_password'],$user->password))
            return back()->with('error','Your current password is incorrect.');
        $user->update(['password'=>$d['password']]);
        return back()->with('success','Password changed.');
    }
}

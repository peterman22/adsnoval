<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller {
    public function index(){ return view('admin.account',['admins'=>Admin::latest()->get()]); }

    public function changePassword(Request $r){
        $d=$r->validate([
            'current_password'=>'required',
            'password'=>'required|min:8|confirmed',
        ]);
        $admin=auth('admin')->user();
        if(!Hash::check($d['current_password'],$admin->password))
            return back()->with('error','Your current password is incorrect.');
        $admin->update(['password'=>Hash::make($d['password'])]);
        return back()->with('success','Password changed.');
    }

    public function updateProfile(Request $r){
        $admin=auth('admin')->user();
        $d=$r->validate([
            'name'=>'required|string|max:60',
            'email'=>'required|email|max:120|unique:admins,email,'.$admin->id,
        ]);
        $admin->update($d);
        return back()->with('success','Profile updated.');
    }

    public function addAdmin(Request $r){
        $d=$r->validate([
            'name'=>'required|string|max:60',
            'email'=>'required|email|max:120|unique:admins,email',
            'password'=>'required|min:8',
        ]);
        Admin::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make($d['password'])]);
        return back()->with('success','Admin added.');
    }

    public function deleteAdmin(Admin $admin){
        if(Admin::count()<=1) return back()->with('error','You cannot delete the only admin.');
        if($admin->id===auth('admin')->id()) return back()->with('error','You cannot delete yourself.');
        $admin->delete();
        return back()->with('success','Admin removed.');
    }
}

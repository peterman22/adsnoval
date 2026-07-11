<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Wallet;
use Illuminate\Http\Request;
class UserController extends Controller {
    public function index(Request $r){
        $q=User::latest();
        if($r->q) $q->where(fn($x)=>$x->where('username','like',"%{$r->q}%")->orWhere('email','like',"%{$r->q}%"));
        return view('admin.users',['users'=>$q->paginate(25),'q'=>$r->q]);
    }
    public function toggleBan(User $user){ $user->update(['is_banned'=>!$user->is_banned]); return back()->with('success','User updated.'); }
    public function adjustBalance(Request $r,User $user){
        $d=$r->validate(['amount'=>'required|numeric','note'=>'nullable|string|max:120']);
        if($d['amount']>=0) Wallet::credit($user,$d['amount'],'admin_credit',$d['note']??'Admin adjustment');
        else Wallet::debit($user,abs($d['amount']),'admin_debit',$d['note']??'Admin adjustment');
        return back()->with('success','Balance adjusted.');
    }
}

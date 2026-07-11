<?php
namespace App\Http\Controllers;
use App\Models\Commission;
class ReferralController extends Controller {
    public function index(){
        $user=auth()->user();
        return view('referrals.index',[
            'user'=>$user,
            'referrals'=>$user->referrals()->latest()->paginate(20),
            'earned'=>Commission::where('to_user_id',$user->id)->sum('amount'),
            'count'=>$user->referrals()->count(),
        ]);
    }
}

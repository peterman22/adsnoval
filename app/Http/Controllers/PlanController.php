<?php
namespace App\Http\Controllers;
use App\Models\Plan;
use App\Services\Wallet;
use Illuminate\Http\Request;
class PlanController extends Controller {
    public function index(){
        return view('plans.index',['plans'=>Plan::active()->orderBy('price')->get(),'user'=>auth()->user()]);
    }
    public function buy(Request $r,Plan $plan){
        $user=auth()->user();
        if(!$plan->is_active) return back()->with('error','This plan is not available.');
        if($plan->price>0 && $user->balance<$plan->price) return back()->with('error','Insufficient balance. Please deposit first.');
        if($plan->price>0) Wallet::debit($user,(float)$plan->price,'plan_purchase','Purchased '.$plan->name.' plan');
        $user->update([
            'plan_id'=>$plan->id,
            'plan_expires_at'=>now()->addDays($plan->validity_days),
            'daily_limit'=>$plan->daily_limit,
        ]);
        return redirect()->route('dashboard')->with('success','You are now on the '.$plan->name.' plan!');
    }
}

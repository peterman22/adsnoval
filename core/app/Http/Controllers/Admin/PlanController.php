<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Referral;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Subscription Plan';
        $levels    = Referral::max('level');
        $plans     = Plan::get();
        return view('admin.plan',compact('pageTitle','levels','plans'));
    }

    public function savePlan(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'tagline'     => 'required',
            'price'       => 'required|numeric|min:0',
            'daily_limit' => 'required|numeric|min:1',
            'ref_level'   => 'required|numeric|min:0',
            'validity'    => 'required|min:0',
        ]);

        if($request->id == 0){
            $plan = new Plan();
        }else{
            $plan = Plan::findOrFail($request->id);
        }
        $plan->name        = $request->name;
        $plan->tagline     = $request->tagline;
        $plan->price       = $request->price;
        $plan->daily_limit = $request->daily_limit;
        $plan->ref_level   = $request->ref_level;
        $plan->validity    = $request->validity;
        $plan->highlight   = isset($request->highlight) ? Status::YES : Status::NO;
        $plan->save();

        $notify[] = ['success', 'Plan has been Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function status(Request $request){

        return Plan::changeStatus($request->id);
    }

}

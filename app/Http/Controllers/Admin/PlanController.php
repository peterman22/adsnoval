<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
class PlanController extends Controller {
    public function index(){ return view('admin.plans',['plans'=>Plan::latest()->get()]); }
    protected function rules(){ return [
        'name'=>'required|string|max:60','price'=>'required|numeric|min:0',
        'daily_limit'=>'required|integer|min:1','click_value'=>'required|numeric|min:0',
        'validity_days'=>'required|integer|min:1','ref_levels'=>'required|integer|min:0|max:3',
    ]; }
    public function store(Request $r){
        $d=$r->validate($this->rules());
        $d['is_popular']=$r->boolean('is_popular'); $d['is_active']=$r->boolean('is_active',true);
        Plan::create($d);
        return back()->with('success','Plan created.');
    }
    public function update(Request $r,Plan $plan){
        $d=$r->validate($this->rules());
        $d['is_popular']=$r->boolean('is_popular'); $d['is_active']=$r->boolean('is_active');
        $plan->update($d);
        return back()->with('success','Plan updated.');
    }
    public function destroy(Plan $plan){ $plan->delete(); return back()->with('success','Plan deleted.'); }
}

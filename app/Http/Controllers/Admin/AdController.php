<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
class AdController extends Controller {
    public function index(){ return view('admin.ads',['ads'=>Ad::latest()->paginate(20)]); }
    protected function rules(){ return [
        'title'=>'required|string|max:120','type'=>'required|in:1,2,3,4','body'=>'required|string',
        'reward'=>'required|numeric|min:0','duration'=>'required|integer|min:1','max_views'=>'required|integer|min:1',
    ]; }
    public function store(Request $r){
        $d=$r->validate($this->rules());
        $d['views_left']=$d['max_views']; $d['status']=$r->boolean('active',true)?1:0;
        Ad::create($d);
        return back()->with('success','Ad created.');
    }
    public function update(Request $r,Ad $ad){
        $d=$r->validate($this->rules());
        // keep already-served views; adjust remaining
        $d['views_left']=max(0,$d['max_views']-$ad->views_done);
        $d['status']=$r->boolean('active')?1:0;
        $ad->update($d);
        return back()->with('success','Ad updated.');
    }
    public function destroy(Ad $ad){ $ad->delete(); return back()->with('success','Ad deleted.'); }
}

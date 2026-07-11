<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Setting,EmailTemplate};
use Illuminate\Http\Request;
class SettingController extends Controller {
    public function index(){ return view('admin.settings',['s'=>fn($k,$d='')=>Setting::val($k,$d)]); }
    public function save(Request $r){
        foreach($r->except('_token') as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v]);
        return back()->with('success','Settings saved.');
    }
    public function templates(){ return view('admin.templates',['templates'=>EmailTemplate::all()]); }
    public function saveTemplate(Request $r,EmailTemplate $template){
        $template->update($r->validate([
            'subject'=>'required|string|max:191','body'=>'required|string','is_active'=>'nullable',
        ])+['is_active'=>$r->boolean('is_active')]);
        return back()->with('success','Template saved.');
    }
}

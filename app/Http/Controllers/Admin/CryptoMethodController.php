<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CryptoMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CryptoMethodController extends Controller {
    public function index(){ return view('admin.crypto',['methods'=>CryptoMethod::latest()->get()]); }
    protected function rules(){ return [
        'name'=>'required|string|max:60','currency'=>'required|string|max:20','network'=>'nullable|string|max:40',
        'address'=>'required|string|max:191','min_amount'=>'required|numeric|min:0','max_amount'=>'required|numeric|min:1',
        'qr'=>'nullable|image|max:2048',
    ]; }
    public function store(Request $r){
        $d=$r->validate($this->rules()); unset($d['qr']);
        $d['is_active']=$r->boolean('is_active',true);
        if($r->hasFile('qr')) $d['qr_path']=$r->file('qr')->store('qr','public');
        CryptoMethod::create($d); return back()->with('success','Wallet added.');
    }
    public function update(Request $r,CryptoMethod $method){
        $d=$r->validate($this->rules()); unset($d['qr']);
        $d['is_active']=$r->boolean('is_active');
        if($r->hasFile('qr')){
            if($method->qr_path) Storage::disk('public')->delete($method->qr_path);
            $d['qr_path']=$r->file('qr')->store('qr','public');
        }
        $method->update($d); return back()->with('success','Wallet updated.');
    }
    public function destroy(CryptoMethod $method){
        if($method->qr_path) Storage::disk('public')->delete($method->qr_path);
        $method->delete(); return back()->with('success','Wallet deleted.');
    }
}

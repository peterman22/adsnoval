<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Services\{Wallet,Mailer};
use Illuminate\Http\Request;
class DepositController extends Controller {
    public function index(Request $r){
        $q=Deposit::with(['user','method'])->latest();
        if($r->status!==null && $r->status!=='') $q->where('status',(int)$r->status);
        return view('admin.deposits',['deposits'=>$q->paginate(20),'status'=>$r->status]);
    }
    public function approve(Deposit $deposit){
        if($deposit->status!=2) return back()->with('error','Already processed.');
        $deposit->update(['status'=>1]);
        $trx=Wallet::credit($deposit->user,(float)$deposit->amount,'deposit','Deposit approved',$deposit->trx);
        Mailer::sendTemplate($deposit->user->email,'transaction',[
            'name'=>$deposit->user->name,'title'=>'Deposit approved','type'=>'Deposit',
            'amount'=>'$'.number_format($deposit->amount,2),'balance'=>'$'.number_format($deposit->user->balance,2),'trx'=>$deposit->trx]);
        return back()->with('success','Deposit approved and credited.');
    }
    public function reject(Request $r,Deposit $deposit){
        if($deposit->status!=2) return back()->with('error','Already processed.');
        $deposit->update(['status'=>3,'admin_note'=>$r->input('note')]);
        return back()->with('success','Deposit rejected.');
    }
}

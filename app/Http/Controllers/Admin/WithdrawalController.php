<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\{Wallet,Mailer};
use Illuminate\Http\Request;
class WithdrawalController extends Controller {
    public function index(Request $r){
        $q=Withdrawal::with('user')->latest();
        if($r->status!==null && $r->status!=='') $q->where('status',(int)$r->status);
        return view('admin.withdrawals',['withdrawals'=>$q->paginate(20),'status'=>$r->status]);
    }
    public function markPaid(Request $r,Withdrawal $withdrawal){
        if($withdrawal->status!=2) return back()->with('error','Already processed.');
        $withdrawal->update(['status'=>1,'payout_txid'=>$r->input('txid')]);
        Mailer::sendTemplate($withdrawal->user->email,'transaction',[
            'name'=>$withdrawal->user->name,'title'=>'Withdrawal paid','type'=>'Withdrawal',
            'amount'=>'$'.number_format($withdrawal->amount,2),'balance'=>'$'.number_format($withdrawal->user->balance,2),'trx'=>$withdrawal->trx]);
        return back()->with('success','Marked as paid.');
    }
    public function reject(Request $r,Withdrawal $withdrawal){
        if($withdrawal->status!=2) return back()->with('error','Already processed.');
        $d=$r->validate(['note'=>'required|string|max:255']);
        // refund the held balance
        Wallet::credit($withdrawal->user,(float)$withdrawal->amount,'withdraw_refund','Withdrawal rejected refund');
        $withdrawal->update(['status'=>3,'admin_note'=>$d['note']]);
        Mailer::sendTemplate($withdrawal->user->email,'transaction',[
            'name'=>$withdrawal->user->name,'title'=>'Withdrawal rejected','type'=>'Withdrawal refund',
            'amount'=>'$'.number_format($withdrawal->amount,2),'balance'=>'$'.number_format($withdrawal->user->balance,2),'trx'=>$withdrawal->trx]);
        return back()->with('success','Withdrawal rejected and refunded.');
    }
}

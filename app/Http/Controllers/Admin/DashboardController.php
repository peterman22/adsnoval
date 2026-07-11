<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{User,Deposit,Withdrawal,Ad,Transaction};
class DashboardController extends Controller {
    public function index(){
        $stats=[
            'users'=>User::count(),
            'balance'=>User::sum('balance'),
            'deposits_pending'=>Deposit::pending()->count(),
            'withdraws_pending'=>Withdrawal::pending()->count(),
            'deposits_total'=>Deposit::approved()->sum('amount'),
            'withdraws_total'=>Withdrawal::paid()->sum('amount'),
            'ads'=>Ad::count(),
            'earned'=>Transaction::where('remark','ad_earn')->sum('amount'),
        ];
        $recentDeposits=Deposit::with('user')->latest()->limit(6)->get();
        $recentWithdraws=Withdrawal::with('user')->latest()->limit(6)->get();
        return view('admin.dashboard',compact('stats','recentDeposits','recentWithdraws'));
    }
}

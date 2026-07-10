<?php

namespace App\Http\Controllers;

use App\Models\CryptoMethod;
use App\Models\Setting;
use App\Models\Withdrawal;
use App\Services\Wallet;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user        = auth()->user();
        $currencies  = CryptoMethod::active()->get();
        $withdrawals = $user->withdrawals()->limit(20)->get();
        $minWithdraw = (float) Setting::val('min_withdraw', 5);

        return view('withdrawals.index', compact('user', 'currencies', 'withdrawals', 'minWithdraw'));
    }

    public function store(Request $request)
    {
        $user        = auth()->user();
        $minWithdraw = (float) Setting::val('min_withdraw', 5);

        $data = $request->validate([
            'amount'         => 'required|numeric|min:'.$minWithdraw,
            'currency'       => 'required|string|max:20',
            'wallet_address' => 'required|string|max:191',
        ]);

        if ($data['amount'] > $user->balance) {
            return back()->with('error', 'Insufficient balance.')->withInput();
        }

        // Hold the funds now; admin refunds on rejection.
        $trx = Wallet::trx();
        Wallet::debit($user, (float) $data['amount'], 'withdraw', 'Withdrawal request ('.$data['currency'].')', $trx);

        Withdrawal::create([
            'user_id'        => $user->id,
            'trx'            => $trx,
            'amount'         => $data['amount'],
            'currency'       => $data['currency'],
            'wallet_address' => $data['wallet_address'],
            'status'         => 2, // pending
        ]);

        return redirect()->route('withdrawals.index')
            ->with('success', 'Withdrawal requested! You will be paid after review.');
    }
}

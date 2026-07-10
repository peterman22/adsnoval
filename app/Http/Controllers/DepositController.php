<?php

namespace App\Http\Controllers;

use App\Models\CryptoMethod;
use App\Models\Deposit;
use App\Services\Wallet;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $methods  = CryptoMethod::active()->get();
        $deposits = auth()->user()->deposits()->with('method')->limit(20)->get();
        return view('deposits.index', compact('methods', 'deposits'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'crypto_method_id' => 'required|exists:crypto_methods,id',
            'amount'           => 'required|numeric|min:1',
            'sent_amount'      => 'nullable|numeric|min:0',
            'sender_txid'      => 'required|string|max:191',
            'proof'            => 'nullable|image|max:4096',
        ]);

        $method = CryptoMethod::active()->findOrFail($data['crypto_method_id']);

        if ($data['amount'] < $method->min_amount || $data['amount'] > $method->max_amount) {
            return back()->with('error', "Amount must be between {$method->min_amount} and {$method->max_amount}.")->withInput();
        }

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('deposits', 'public');
        }

        Deposit::create([
            'user_id'          => auth()->id(),
            'crypto_method_id' => $method->id,
            'trx'              => Wallet::trx(),
            'amount'           => $data['amount'],
            'sent_amount'      => $data['sent_amount'] ?? null,
            'sender_txid'      => $data['sender_txid'],
            'proof_path'       => $proofPath,
            'status'           => 2, // pending
        ]);

        return redirect()->route('deposits.index')
            ->with('success', 'Deposit submitted! It will be credited after we verify your transaction.');
    }
}

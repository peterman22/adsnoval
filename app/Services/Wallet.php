<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * Central money movement: every balance change goes through here and writes
 * a transaction ledger row.
 */
class Wallet
{
    public static function trx(): string
    {
        return strtoupper(Str::random(12));
    }

    public static function credit(User $user, float $amount, string $remark, ?string $details = null, ?string $trx = null): Transaction
    {
        return self::move($user, abs($amount), '+', $remark, $details, $trx);
    }

    public static function debit(User $user, float $amount, string $remark, ?string $details = null, ?string $trx = null): Transaction
    {
        return self::move($user, abs($amount), '-', $remark, $details, $trx);
    }

    protected static function move(User $user, float $amount, string $type, string $remark, ?string $details, ?string $trx): Transaction
    {
        return DB::transaction(function () use ($user, $amount, $type, $remark, $details, $trx) {
            // Lock the row to keep the balance consistent under concurrency.
            $fresh = User::whereKey($user->id)->lockForUpdate()->first();
            $fresh->balance = $type === '+' ? $fresh->balance + $amount : $fresh->balance - $amount;
            $fresh->save();
            $user->balance = $fresh->balance;

            return Transaction::create([
                'user_id'      => $user->id,
                'trx'          => $trx ?: self::trx(),
                'amount'       => $amount,
                'post_balance' => $fresh->balance,
                'type'         => $type,
                'remark'       => $remark,
                'details'      => $details,
            ]);
        });
    }
}

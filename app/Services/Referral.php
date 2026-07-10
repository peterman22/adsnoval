<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Setting;
use App\Models\User;

/**
 * Pays multi-level referral commissions up a user's upline when they earn.
 * Percentages per level are configurable via settings (ref_percent_1..3).
 */
class Referral
{
    public static function payCommission(User $earner, float $baseAmount, string $remark = 'ad_commission'): void
    {
        $percents = [
            1 => (float) Setting::val('ref_percent_1', 10),
            2 => (float) Setting::val('ref_percent_2', 3),
            3 => (float) Setting::val('ref_percent_3', 1),
        ];

        $upline = $earner->referrer;
        $level  = 1;

        while ($upline && $level <= 3) {
            $pct = $percents[$level] ?? 0;
            if ($pct > 0) {
                $amount = round($baseAmount * $pct / 100, 4);
                if ($amount > 0) {
                    Wallet::credit($upline, $amount, $remark, "Level {$level} commission from {$earner->username}");
                    Commission::create([
                        'from_user_id' => $earner->id,
                        'to_user_id'   => $upline->id,
                        'level'        => $level,
                        'amount'       => $amount,
                        'remark'       => $remark,
                    ]);
                }
            }
            $upline = $upline->referrer;
            $level++;
        }
    }
}

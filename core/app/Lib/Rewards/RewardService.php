<?php

namespace App\Lib\Rewards;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

/**
 * Core logic for daily streak check-ins and spin-the-wheel. Kept free of
 * HTTP/request concerns so it can be exercised directly (and tested).
 */
class RewardService
{
    /* ----------------------------- Streak ------------------------------ */

    public function canCheckIn(User $user): bool
    {
        if (!config('rewards.streak.enabled')) {
            return false;
        }
        return (string) $user->last_check_in !== Carbon::today()->toDateString();
    }

    /**
     * Claim today's streak reward. Returns [reward, streak] or throws if the
     * user already claimed today.
     */
    public function checkIn(User $user): array
    {
        if (!$this->canCheckIn($user)) {
            throw new RewardException('You have already claimed your daily bonus. Come back tomorrow!');
        }

        $today     = Carbon::today();
        $yesterday = $today->copy()->subDay()->toDateString();

        // Continue the streak only if the last check-in was yesterday.
        if ((string) $user->last_check_in === $yesterday) {
            $user->streak_count = (int) $user->streak_count + 1;
        } else {
            $user->streak_count = 1;
        }

        $reward = $this->streakReward((int) $user->streak_count);

        $user->balance      = (float) $user->balance + $reward;
        $user->last_check_in = $today->toDateString();
        $user->save();

        $this->credit($user, $reward, 'streak_bonus', 'Daily streak bonus (day ' . $user->streak_count . ')');

        return ['reward' => $reward, 'streak' => (int) $user->streak_count];
    }

    /** Reward for a given streak day = highest unlocked tier. */
    public function streakReward(int $streakDay): float
    {
        $tiers  = config('rewards.streak.tiers', []);
        ksort($tiers);
        $reward = 0.0;
        foreach ($tiers as $day => $amount) {
            if ($streakDay >= $day) {
                $reward = (float) $amount;
            }
        }
        return $reward;
    }

    /* ------------------------------ Spin ------------------------------- */

    public function canSpin(User $user): bool
    {
        if (!config('rewards.spin.enabled')) {
            return false;
        }
        return (string) $user->last_spin_at !== Carbon::today()->toDateString();
    }

    /**
     * Perform a weighted spin. Returns ['index' => int, 'amount' => float,
     * 'label' => string]. Throws if the user already spun today.
     */
    public function spin(User $user): array
    {
        if (!$this->canSpin($user)) {
            throw new RewardException('You have already spun today. Come back tomorrow for another free spin!');
        }

        $segments = config('rewards.spin.segments', []);
        $index    = $this->weightedPick($segments);
        $segment  = $segments[$index];
        $amount   = (float) $segment['amount'];

        $user->balance      = (float) $user->balance + $amount;
        $user->last_spin_at = Carbon::today()->toDateString();
        $user->save();

        $this->credit($user, $amount, 'spin_reward', 'Spin the wheel reward');

        return ['index' => $index, 'amount' => $amount, 'label' => $segment['label']];
    }

    /** Pick a segment index proportional to its weight. */
    protected function weightedPick(array $segments): int
    {
        $total = array_sum(array_column($segments, 'weight'));
        if ($total <= 0) {
            return 0;
        }
        $roll = random_int(1, $total);
        $acc  = 0;
        foreach ($segments as $i => $segment) {
            $acc += (int) $segment['weight'];
            if ($roll <= $acc) {
                return $i;
            }
        }
        return count($segments) - 1;
    }

    /* ----------------------------- Shared ------------------------------ */

    protected function credit(User $user, float $amount, string $remark, string $details): void
    {
        if ($amount <= 0) {
            return;
        }
        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = $details;
        $transaction->trx          = getTrx();
        $transaction->remark       = $remark;
        $transaction->save();
    }
}

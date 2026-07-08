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
     * Perform the daily spin. Every `free_ad_every` spins lands on the
     * "1 Free Ad" slice; otherwise a weighted cash slice is chosen. Decoy
     * slices ($50/$100) are shown on the wheel but never awarded.
     *
     * Returns ['index' => int, 'type' => string, 'amount' => float,
     * 'label' => string, 'free_ad_credits' => int].
     */
    public function spin(User $user): array
    {
        if (!$this->canSpin($user)) {
            throw new RewardException('You have already spun today. Come back tomorrow for another free spin!');
        }

        $segments   = config('rewards.spin.segments', []);
        $everyN      = max(1, (int) config('rewards.spin.free_ad_every', 5));
        $spinNumber = (int) $user->spin_count + 1;

        // Decide the winning slice index.
        if ($spinNumber % $everyN === 0 && ($freeAdIndex = $this->indexOfType($segments, 'free_ad')) !== null) {
            $index = $freeAdIndex;
        } else {
            $index = $this->weightedCashPick($segments);
        }

        $segment = $segments[$index];
        $type    = $segment['type'] ?? 'cash';
        $amount  = (float) ($segment['amount'] ?? 0);

        $user->spin_count   = $spinNumber;
        $user->last_spin_at = Carbon::today()->toDateString();

        if ($type === 'free_ad') {
            $user->free_ad_credits = (int) $user->free_ad_credits + 1;
            $amount = 0.0;
            $user->save();
        } else { // cash
            $user->balance = (float) $user->balance + $amount;
            $user->save();
            $this->credit($user, $amount, 'spin_reward', 'Spin the wheel reward');
        }

        return [
            'index'           => $index,
            'type'            => $type,
            'amount'          => $amount,
            'label'           => $segment['label'],
            'free_ad_credits' => (int) $user->free_ad_credits,
        ];
    }

    /** First index whose segment matches the given type, or null. */
    protected function indexOfType(array $segments, string $type): ?int
    {
        foreach ($segments as $i => $s) {
            if (($s['type'] ?? 'cash') === $type) {
                return $i;
            }
        }
        return null;
    }

    /** Pick a cash slice index proportional to its weight (ignores decoy/free_ad). */
    protected function weightedCashPick(array $segments): int
    {
        $cash = array_filter($segments, fn ($s) => ($s['type'] ?? 'cash') === 'cash' && (int) ($s['weight'] ?? 0) > 0);
        $total = array_sum(array_map(fn ($s) => (int) $s['weight'], $cash));
        if ($total <= 0) {
            return array_key_first($cash) ?? 0;
        }
        $roll = random_int(1, $total);
        $acc  = 0;
        foreach ($cash as $i => $segment) {
            $acc += (int) $segment['weight'];
            if ($roll <= $acc) {
                return $i;
            }
        }
        return array_key_last($cash);
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

<?php

namespace App\Http\Controllers;

use App\Services\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $segments = config('rewards.spin.segments');
        $tiers    = config('rewards.streak');
        $today    = Carbon::today()->toDateString();

        return view('rewards.index', [
            'user'         => $user,
            'segments'     => $segments,
            'tiers'        => $tiers,
            'canSpin'      => (string) $user->last_spin_at !== $today,
            'canCheckIn'   => (string) $user->last_check_in !== $today,
            'nextReward'   => $this->streakReward((int) $user->streak_count + 1),
            'freeAdEvery'  => config('rewards.spin.free_ad_every'),
        ]);
    }

    /* ---------------- Daily streak ---------------- */
    public function checkIn(Request $request)
    {
        $user  = auth()->user();
        $today = Carbon::today();

        if ((string) $user->last_check_in === $today->toDateString()) {
            return back()->with('error', 'You already claimed your daily bonus. Come back tomorrow!');
        }

        $yesterday = $today->copy()->subDay()->toDateString();
        $user->streak_count = ((string) $user->last_check_in === $yesterday) ? $user->streak_count + 1 : 1;

        $reward = $this->streakReward((int) $user->streak_count);
        $user->last_check_in = $today->toDateString();
        $user->save();

        if ($reward > 0) {
            Wallet::credit($user, $reward, 'streak_bonus', 'Daily streak day '.$user->streak_count);
        }

        return back()->with('success', 'Daily bonus claimed: $'.number_format($reward, 2).'! Streak: '.$user->streak_count.' day(s).');
    }

    /* ---------------- Spin the wheel ---------------- */
    public function spin(Request $request)
    {
        $user  = auth()->user();
        $today = Carbon::today()->toDateString();

        if ((string) $user->last_spin_at === $today) {
            return response()->json(['status' => 'error', 'message' => 'You already spun today. Come back tomorrow!'], 422);
        }

        $segments  = config('rewards.spin.segments');
        $everyN    = max(1, (int) config('rewards.spin.free_ad_every'));
        $spinNo    = (int) $user->spin_count + 1;

        if ($spinNo % $everyN === 0 && ($idx = $this->indexOfType($segments, 'free_ad')) !== null) {
            $index = $idx;
        } else {
            $index = $this->weightedCashPick($segments);
        }

        $seg    = $segments[$index];
        $type   = $seg['type'];
        $amount = (float) $seg['amount'];

        $user->spin_count   = $spinNo;
        $user->last_spin_at = $today;

        if ($type === 'free_ad') {
            $user->free_ad_credits = (int) $user->free_ad_credits + 1;
            $amount = 0.0;
            $user->save();
        } else {
            $user->save();
            Wallet::credit($user, $amount, 'spin_reward', 'Spin the wheel reward');
        }

        return response()->json([
            'status'          => 'success',
            'index'           => $index,
            'type'            => $type,
            'label'           => $seg['label'],
            'amount'          => $amount,
            'free_ad_credits' => (int) $user->free_ad_credits,
            'balance'         => number_format($user->balance, 2),
            'message'         => $type === 'free_ad' ? 'You won 1 Free Ad!' : 'You won $'.number_format($amount, 2).'!',
        ]);
    }

    /* ---------------- helpers ---------------- */
    protected function streakReward(int $day): float
    {
        $tiers = config('rewards.streak');
        ksort($tiers);
        $reward = 0.0;
        foreach ($tiers as $d => $amt) {
            if ($day >= $d) $reward = (float) $amt;
        }
        return $reward;
    }

    protected function indexOfType(array $segments, string $type): ?int
    {
        foreach ($segments as $i => $s) {
            if (($s['type'] ?? 'cash') === $type) return $i;
        }
        return null;
    }

    protected function weightedCashPick(array $segments): int
    {
        $cash  = array_filter($segments, fn ($s) => ($s['type'] ?? 'cash') === 'cash' && ($s['weight'] ?? 0) > 0);
        $total = array_sum(array_map(fn ($s) => (int) $s['weight'], $cash));
        if ($total <= 0) return array_key_first($cash) ?? 0;

        $roll = random_int(1, $total);
        $acc  = 0;
        foreach ($cash as $i => $s) {
            $acc += (int) $s['weight'];
            if ($roll <= $acc) return $i;
        }
        return array_key_last($cash);
    }
}

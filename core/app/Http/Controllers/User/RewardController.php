<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\Rewards\RewardException;
use App\Lib\Rewards\RewardService;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function __construct(protected RewardService $rewards)
    {
    }

    /** Rewards hub: daily streak + spin-the-wheel. */
    public function index()
    {
        $pageTitle    = 'Daily Rewards';
        $user         = auth()->user();
        $segments     = config('rewards.spin.segments');
        $streakTiers  = config('rewards.streak.tiers');
        $canSpin      = $this->rewards->canSpin($user);
        $canCheckIn   = $this->rewards->canCheckIn($user);
        $nextReward   = $this->rewards->streakReward((int) $user->streak_count + 1);

        return view('Template::user.rewards', compact(
            'pageTitle', 'user', 'segments', 'streakTiers', 'canSpin', 'canCheckIn', 'nextReward'
        ));
    }

    /** Claim today's streak bonus. */
    public function checkIn(Request $request)
    {
        try {
            $result = $this->rewards->checkIn(auth()->user());
        } catch (RewardException $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
            }
            return back()->withNotify([['error', $e->getMessage()]]);
        }

        $message = 'Daily bonus claimed: ' . showAmount($result['reward']) . '! Streak: ' . $result['streak'] . ' day(s).';

        if ($request->ajax()) {
            return response()->json([
                'status'  => 'success',
                'reward'  => $result['reward'],
                'streak'  => $result['streak'],
                'balance' => showAmount(auth()->user()->balance),
                'message' => $message,
            ]);
        }

        return back()->withNotify([['success', $message]]);
    }

    /** Perform the daily free spin. */
    public function spin(Request $request)
    {
        try {
            $result = $this->rewards->spin(auth()->user());
        } catch (RewardException $e) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
            }
            return back()->withNotify([['error', $e->getMessage()]]);
        }

        $message = $result['type'] === 'free_ad'
            ? 'You won 1 Free Ad!'
            : 'You won ' . showAmount($result['amount']) . '!';

        if ($request->ajax()) {
            return response()->json([
                'status'          => 'success',
                'index'           => $result['index'],
                'type'            => $result['type'],
                'amount'          => $result['amount'],
                'label'           => $result['label'],
                'free_ad_credits' => $result['free_ad_credits'],
                'balance'         => showAmount(auth()->user()->balance),
                'message'         => $message,
            ]);
        }

        return back()->withNotify([['success', $message]]);
    }
}

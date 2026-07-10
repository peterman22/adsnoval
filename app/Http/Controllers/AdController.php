<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdView;
use App\Services\Referral;
use App\Services\Wallet;
use Illuminate\Http\Request;

class AdController extends Controller
{
    /** List ads the user can still watch today. */
    public function index()
    {
        $user  = auth()->user();
        $today = now()->toDateString();

        $viewedIds = AdView::where('user_id', $user->id)
            ->whereDate('viewed_on', $today)->pluck('ad_id');

        $ads = Ad::active()
            ->where(fn ($q) => $q->whereNull('user_id')->orWhere('user_id', '!=', $user->id))
            ->whereNotIn('id', $viewedIds)
            ->inRandomOrder()
            ->limit(48)
            ->get();

        $remaining = max(0, $user->effectiveDailyLimit() - $user->viewsToday());

        return view('ads.index', compact('ads', 'remaining', 'user'));
    }

    /** The watch page for a single ad. */
    public function show(Ad $ad)
    {
        $user = auth()->user();

        if ($msg = $this->ineligible($ad, $user)) {
            return redirect()->route('ads.index')->with('error', $msg);
        }

        // Signed token proves the timer started server-side (anti-cheat).
        $startedAt = now()->timestamp;
        $sig       = $this->signature($ad->id, $user->id, $startedAt);
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        session(["cap_{$ad->id}" => $a + $b]);

        return view('ads.show', compact('ad', 'user', 'startedAt', 'sig', 'a', 'b'));
    }

    /** Confirm the view and credit the reward. */
    public function confirm(Request $request, Ad $ad)
    {
        $user = auth()->user();

        $data = $request->validate([
            'started_at' => 'required|integer',
            'sig'        => 'required|string',
            'answer'     => 'required|integer',
        ]);

        if (! hash_equals($this->signature($ad->id, $user->id, (int) $data['started_at']), $data['sig'])) {
            return redirect()->route('ads.index')->with('error', 'Invalid session. Please try again.');
        }

        // Server-side timer check: the ad's duration must actually have elapsed.
        $elapsed = now()->timestamp - (int) $data['started_at'];
        if ($elapsed < $ad->duration) {
            return back()->with('error', 'Please watch the full ad before confirming.');
        }

        // Captcha check.
        if ((int) $data['answer'] !== (int) session("cap_{$ad->id}")) {
            return back()->with('error', 'Wrong verification answer. Please try again.');
        }

        if ($msg = $this->ineligible($ad, $user)) {
            return redirect()->route('ads.index')->with('error', $msg);
        }

        // Credit + record (guarded against double submit by the daily/once check).
        $ad->increment('views_done');
        $ad->decrement('views_left');
        if ($ad->views_left <= 0) {
            $ad->update(['status' => 0]);
        }

        Wallet::credit($user, (float) $ad->reward, 'ad_earn', 'Reward from watching "'.$ad->title.'"');

        AdView::create([
            'ad_id'     => $ad->id,
            'user_id'   => $user->id,
            'reward'    => $ad->reward,
            'viewed_on' => now()->toDateString(),
        ]);

        Referral::payCommission($user, (float) $ad->reward, 'ad_commission');

        session()->forget("cap_{$ad->id}");

        return redirect()->route('ads.index')->with('success', 'You earned $'.number_format($ad->reward, 2).'!');
    }

    /** Returns an error string if the user can't watch this ad, else null. */
    protected function ineligible(Ad $ad, $user): ?string
    {
        if ($ad->status != 1 || $ad->views_left <= 0) {
            return 'This ad is no longer available.';
        }
        if ($ad->user_id === $user->id) {
            return 'You cannot watch your own ad.';
        }
        if ($user->viewsToday() >= $user->effectiveDailyLimit()) {
            return 'You have reached your daily ad limit. Come back tomorrow!';
        }
        $already = AdView::where('user_id', $user->id)->where('ad_id', $ad->id)
            ->whereDate('viewed_on', now()->toDateString())->exists();
        if ($already) {
            return 'You have already watched this ad today.';
        }
        return null;
    }

    protected function signature(int $adId, int $userId, int $ts): string
    {
        return hash_hmac('sha256', "{$adId}|{$userId}|{$ts}", config('app.key'));
    }
}

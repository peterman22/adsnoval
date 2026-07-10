<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'balance'      => $user->balance,
            'today'        => $user->viewsToday(),
            'remaining'    => max(0, $user->effectiveDailyLimit() - $user->viewsToday()),
            'total_views'  => $user->adViews()->count(),
            'total_earned' => $user->adViews()->sum('reward'),
            'referrals'    => $user->referrals()->count(),
            'withdrawn'    => $user->withdrawals()->where('status', 1)->sum('amount'),
            'streak'       => (int) $user->streak_count,
        ];

        return view('dashboard.index', compact('user', 'stats'));
    }
}

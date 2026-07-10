<x-app-layout title="Dashboard">
    @push('head')
    <style>
        .hero-card { background: var(--grad); border-radius: 22px; padding: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; position: relative; overflow: hidden; }
        .hero-card h2 { color: #fff; font-size: 40px; margin: 4px 0 0; }
        .hero-card small { color: rgba(255,255,255,.9); text-transform: uppercase; letter-spacing: .06em; font-size: 12px; }
        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .tiles { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; margin-top: 22px; }
        @media (max-width: 900px){ .tiles { grid-template-columns: 1fr 1fr; } }
        .tile { padding: 20px; }
        .tile .ico { width: 40px; height: 40px; border-radius: 11px; display: grid; place-items: center; font-size: 18px; background: var(--grad-soft); border: 1px solid var(--border-2); margin-bottom: 12px; }
        .tile small { color: var(--muted); font-size: 13px; }
        .tile b { display: block; font-size: 24px; font-family: var(--head); margin-top: 3px; }
    </style>
    @endpush

    <div class="hero-card">
        <div>
            <span class="chip" style="background:rgba(255,255,255,.16);color:#fff;border-color:rgba(255,255,255,.25)">👋 Welcome back</span>
            <div style="margin-top:14px"><small>Available Balance</small><h2>${{ number_format($stats['balance'], 2) }}</h2></div>
        </div>
        <div class="hero-actions">
            <a href="#" class="btn" style="background:#fff;color:#c2410c">▶ Watch Ads</a>
            <a href="#" class="btn btn-ghost" style="background:rgba(255,255,255,.16);color:#fff;border-color:rgba(255,255,255,.3)">🏧 Withdraw</a>
        </div>
    </div>

    <div class="tiles">
        <div class="tile card"><div class="ico">👁️</div><small>Ads watched today</small><b>{{ $stats['today'] }}</b></div>
        <div class="tile card"><div class="ico">⏳</div><small>Remaining today</small><b>{{ $stats['remaining'] }}</b></div>
        <div class="tile card"><div class="ico">🏆</div><small>Total watched</small><b>{{ $stats['total_views'] }}</b></div>
        <div class="tile card"><div class="ico">💰</div><small>Total earned</small><b>${{ number_format($stats['total_earned'], 2) }}</b></div>
        <div class="tile card"><div class="ico">🔥</div><small>Day streak</small><b>{{ $stats['streak'] }}</b></div>
        <div class="tile card"><div class="ico">🤝</div><small>Referrals</small><b>{{ $stats['referrals'] }}</b></div>
        <div class="tile card"><div class="ico">🏧</div><small>Total withdrawn</small><b>${{ number_format($stats['withdrawn'], 2) }}</b></div>
        <div class="tile card"><div class="ico">👑</div><small>Plan</small><b style="font-size:17px">{{ $user->plan?->name ?? 'Free' }}</b></div>
    </div>

    <div class="card" style="margin-top:22px">
        <h3 style="font-size:18px">Your referral link</h3>
        <p style="margin-bottom:12px">Share this link and earn commissions when your friends earn.</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <input class="input" style="flex:1;min-width:240px" readonly value="{{ route('register', ['ref' => $user->ref_code]) }}">
            <span class="btn btn-ghost">Code: {{ $user->ref_code }}</span>
        </div>
    </div>
</x-app-layout>

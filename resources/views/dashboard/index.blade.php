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
        .dash-row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-top: 22px; }
        @media (max-width: 900px){ .dash-row { grid-template-columns: 1fr; } }
        .spin-card { display: flex; align-items: center; gap: 20px; }
        .mini-wheel { flex: 0 0 110px; width: 110px; height: 110px; border-radius: 50%; border: 6px solid rgba(255,255,255,.08); box-shadow: 0 0 0 5px rgba(255,122,26,.25); background: conic-gradient(#7c1f6e 0 45deg,#3a1e6e 45deg 90deg,#8a3d1a 90deg 135deg,#5a2ea8 135deg 180deg,#a3521a 180deg 225deg,#42277a 225deg 270deg,#7c1f6e 270deg 315deg,#5a2ea8 315deg 360deg); position: relative; }
        .mini-wheel::after { content:''; position:absolute; inset:0; margin:auto; width:18px; height:18px; border-radius:50%; background:#fff; box-shadow:0 0 0 5px rgba(255,122,26,.55); }
        .payrow { display: flex; align-items: center; gap: 10px; padding: 9px 11px; border-radius: 11px; background: rgba(255,255,255,.03); border: 1px solid var(--border); margin-bottom: 7px; }
        .payrow .av { width: 28px; height: 28px; border-radius: 50%; display: grid; place-items: center; font-weight: 800; font-size: 11px; background: var(--grad-soft); color: var(--brand-2); }
        .payrow .t { flex: 1; min-width: 0; font-weight: 700; font-size: 13px; overflow: hidden; } .payrow .t small { display: block; color: var(--muted); font-size: 11px; }
        .payrow .amt { font-weight: 800; color: var(--green); font-size: 13px; white-space: nowrap; }
    </style>
    @endpush

    <div class="hero-card">
        <div>
            <span class="chip" style="background:rgba(255,255,255,.16);color:#fff;border-color:rgba(255,255,255,.25)"><x-icon name="hand" size="15" /> Welcome back</span>
            <div style="margin-top:14px"><small>Available Balance</small><h2>${{ number_format($stats['balance'], 2) }}</h2></div>
        </div>
        <div class="hero-actions">
            <a href="{{ route('ads.index') }}" class="btn" style="background:#fff;color:#c2410c"><x-icon name="play" size="15" /> Watch Ads</a>
            <a href="{{ route('withdrawals.index') }}" class="btn btn-ghost" style="background:rgba(255,255,255,.16);color:#fff;border-color:rgba(255,255,255,.3)"><x-icon name="banknote" size="16" /> Withdraw</a>
        </div>
    </div>

    <div class="tiles">
        <div class="tile card"><div class="ico"><x-icon name="eye" size="20" /></div><small>Ads watched today</small><b>{{ $stats['today'] }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="hourglass" size="20" /></div><small>Remaining today</small><b>{{ $stats['remaining'] }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="trophy" size="20" /></div><small>Total watched</small><b>{{ $stats['total_views'] }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="wallet" size="20" /></div><small>Total earned</small><b>${{ number_format($stats['total_earned'], 2) }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="flame" size="20" /></div><small>Day streak</small><b>{{ $stats['streak'] }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="handshake" size="20" /></div><small>Referrals</small><b>{{ $stats['referrals'] }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="banknote" size="20" /></div><small>Total withdrawn</small><b>${{ number_format($stats['withdrawn'], 2) }}</b></div>
        <div class="tile card"><div class="ico"><x-icon name="crown" size="20" /></div><small>Plan</small><b style="font-size:17px">{{ $user->plan?->name ?? 'Free' }}</b></div>
    </div>

    @php $canSpin = (string) ($user->last_spin_at ?? '') !== \Carbon\Carbon::today()->toDateString(); @endphp
    <div class="dash-row">
        <!-- Spin card -->
        <div class="card spin-card">
            <div class="mini-wheel"></div>
            <div>
                <span class="chip"><x-icon name="ferris-wheel" size="16" /> Daily Spin</span>
                <h3 style="font-size:18px;margin:10px 0 4px">{{ $canSpin ? 'Your free spin is ready!' : 'Come back tomorrow' }}</h3>
                <p class="muted" style="margin:0 0 12px;font-size:14px"><x-icon name="flame" size="14" /> {{ $stats['streak'] }}-day streak · spin daily for cash &amp; free ads.</p>
                <a href="{{ route('rewards.index') }}" class="btn {{ $canSpin ? 'btn-primary' : 'btn-ghost' }}">{{ $canSpin ? 'Spin the Wheel →' : 'View Rewards →' }}</a>
            </div>
        </div>

        <!-- Live payouts card -->
        <div class="card">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px">
                <span class="pulse-dot"></span><b>Live Payouts</b>
                <span class="muted" id="dpTotal" style="margin-left:auto;font-size:13px"></span>
            </div>
            <div id="dpFeed"><p class="muted" style="margin:0">Loading recent payouts…</p></div>
        </div>
    </div>

    <div class="card" style="margin-top:22px">
        <h3 style="font-size:18px">Your referral link</h3>
        <p style="margin-bottom:12px">Share this link and earn commissions when your friends earn.</p>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <input class="input" style="flex:1;min-width:240px" readonly value="{{ route('register', ['ref' => $user->ref_code]) }}">
            <span class="btn btn-ghost">Code: {{ $user->ref_code }}</span>
        </div>
    </div>

    @push('scripts')
    <script>
        function dpInit(n){ return (n||'?')[0].toUpperCase(); }
        function dpLoad(){
            fetch('{{ route('withdraw.feed') }}').then(function(r){return r.json();}).then(function(res){
                if(res.status!=='success') return;
                document.getElementById('dpTotal').textContent = 'Paid: ' + res.total;
                var h=''; res.feed.slice(0,5).forEach(function(f){
                    h+='<div class="payrow"><span class="av">'+dpInit(f.user)+'</span><span class="t">'+f.user+'<small>'+f.method+' · '+f.ago+'</small></span><span class="amt">'+f.amount+'</span></div>';
                });
                document.getElementById('dpFeed').innerHTML=h;
            }).catch(function(){});
        }
        dpLoad(); setInterval(dpLoad, 20000);
    </script>
    @endpush
</x-app-layout>

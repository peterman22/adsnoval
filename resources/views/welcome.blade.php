<x-guest-layout>
    @php
        $calcPlans = $plans->map(fn($p) => ['name'=>$p->name,'limit'=>$p->daily_limit,'value'=>(float)$p->click_value])->values();
    @endphp
    @push('head')
    <style>
        .hero { padding: 70px 0 84px; }
        .hero-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 46px; align-items: center; }
        .hero h1 { font-size: clamp(38px, 5.2vw, 60px); }
        .hero p.lead { font-size: 19px; max-width: 520px; }
        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 26px; }
        @media (max-width: 900px){ .hero-grid { grid-template-columns: 1fr; } }

        .phone { width: 290px; max-width: 100%; margin: 0 auto; border-radius: 40px; padding: 12px; background: linear-gradient(160deg,#20222b,#0b0b0f); box-shadow: var(--shadow), 0 0 70px rgba(255,122,26,.2); animation: floaty 6s ease-in-out infinite; }
        .phone-screen { border-radius: 30px; overflow: hidden; background: var(--bg); padding: 16px 14px; }
        .balance { background: var(--grad); border-radius: 18px; padding: 18px; text-align: center; }
        .balance small { color: rgba(255,255,255,.9); text-transform: uppercase; font-size: 10px; letter-spacing: .08em; }
        .balance h3 { font-size: 30px; color: #fff; margin: 4px 0 12px; }
        .balance .row { display: flex; gap: 8px; } .balance .b { flex: 1; padding: 8px; border-radius: 10px; font-weight: 700; font-size: 12px; }
        .mini { display: grid; grid-template-columns: 1fr 1fr; gap: 9px; margin-top: 11px; }
        .mini .t { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 11px; }
        .mini .t small { color: var(--muted); font-size: 10px; } .mini .t b { display: block; font-size: 16px; margin-top: 3px; }

        .stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; }
        @media (max-width: 700px){ .stats { grid-template-columns: 1fr 1fr; } }
        .stat { text-align: center; padding: 22px; } .stat b { font-family: var(--head); font-size: 30px; display: block; }

        .feature { padding: 24px; transition: transform .25s, border-color .25s; }
        .feature:hover { transform: translateY(-6px); border-color: rgba(255,122,26,.4); }
        .feature .ico { width: 50px; height: 50px; border-radius: 14px; display: grid; place-items: center; font-size: 23px; background: var(--grad-soft); border: 1px solid var(--border-2); margin-bottom: 14px; }
        .feature h3 { font-size: 19px; }

        .showcase { overflow: hidden; }
        .screens { display: flex; gap: 16px; overflow-x: auto; padding: 6px 0 14px; scrollbar-width: none; }
        .screens::-webkit-scrollbar { display: none; }
        .screen { flex: 0 0 200px; border-radius: 24px; padding: 8px; background: linear-gradient(160deg,#20222b,#0b0b0f); border: 1px solid var(--border-2); }
        .screen .inner { border-radius: 18px; background: var(--bg); padding: 12px 10px; min-height: 330px; }
        .screen .hd { display:flex;align-items:center;gap:7px;margin-bottom:10px;font-size:12px;font-weight:700 }
        .screen .hd .m { width:20px;height:20px;border-radius:6px;background:var(--grad-warm);display:grid;place-items:center;font-size:10px;color:#1a1205 }
        .sbal { background: var(--grad); border-radius: 12px; padding: 12px; text-align:center; margin-bottom:10px }
        .sbal b { color:#fff; font-size:20px; display:block }
        .srow { display:flex;align-items:center;gap:8px;padding:7px 0;border-bottom:1px solid var(--border);font-size:12px }
        .sav { width:22px;height:22px;border-radius:6px;background:var(--grad-soft);display:grid;place-items:center;color:var(--brand-2);font-weight:800;font-size:10px }
        .sw { width:100px;height:100px;border-radius:50%;margin:10px auto;background:conic-gradient(#7c1f6e 0 45deg,#3a1e6e 45deg 90deg,#8a3d1a 90deg 135deg,#5a2ea8 135deg 180deg,#a3521a 180deg 225deg,#42277a 225deg 270deg,#7c1f6e 270deg 315deg,#5a2ea8 315deg 360deg);border:4px solid rgba(255,255,255,.1) }

        .payrow { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 12px; background: rgba(255,255,255,.03); border: 1px solid var(--border); margin-bottom: 8px; }
        .payrow .av { width: 30px; height: 30px; border-radius: 50%; display: grid; place-items: center; font-weight: 800; font-size: 12px; background: var(--grad-soft); color: var(--brand-2); }
        .payrow .t { flex: 1; min-width: 0; font-weight: 700; font-size: 13px; } .payrow .t small { display: block; color: var(--muted); font-size: 11px; }
        .payrow .amt { font-weight: 800; color: var(--green); font-size: 13px; white-space: nowrap; }

        .range { width: 100%; accent-color: var(--brand); }
        .results { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin: 20px 0; }
        .results .r { text-align: center; padding: 16px 8px; border-radius: 14px; background: rgba(255,255,255,.03); border: 1px solid var(--border); }
        .results .r.hl { background: var(--grad-soft); border-color: rgba(255,122,26,.4); }
        .results .r small { color: var(--muted); font-size: 12px; } .results .r b { display: block; font-size: 22px; font-family: var(--head); margin-top: 4px; }

        .testi { padding: 24px; } .testi .stars { color: var(--brand); }
        .cta-band { background: var(--grad); border-radius: 28px; padding: 54px; text-align: center; }
        .cta-band h2 { color: #fff; font-size: clamp(28px,4vw,42px); } .cta-band p { color: rgba(255,255,255,.9); }
        .sec-head { text-align:center; max-width:620px; margin:0 auto 44px; }
        .sec-head h2 { font-size: clamp(28px,4vw,40px); margin-top: 14px; }
    </style>
    @endpush

    <!-- Hero -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="chip">💸 Get paid to watch ads</span>
                <h1 style="margin-top:16px">Turn every click into <span class="grad-text">real cash</span></h1>
                <p class="lead">Trusted by thousands worldwide. Start earning in just a few clicks with zero upfront cost — watch ads, spin, refer, and cash out in crypto.</p>
                <div class="hero-cta">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Start earning free →</a>
                    <a href="#how" class="btn btn-ghost btn-lg">How it works</a>
                </div>
                <p class="muted" style="margin-top:16px;font-size:13px">⭐ <b style="color:var(--text)">5,000+</b> users have joined our platform</p>
            </div>
            <div>
                <div class="phone">
                    <div class="phone-screen">
                        <div class="balance"><small>My Balance</small><h3>$8,042.50</h3>
                            <div class="row"><span class="b" style="background:rgba(255,255,255,.18);color:#fff">Upgrade</span><span class="b" style="background:#fff;color:#c2410c">Withdraw</span></div></div>
                        <div class="mini">
                            <div class="t"><small>Today</small><b style="color:var(--green)">+$4.20</b></div>
                            <div class="t"><small>Streak</small><b>6 🔥</b></div>
                            <div class="t"><small>Referrals</small><b>18</b></div>
                            <div class="t"><small>Spins</small><b>1 🎡</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features + stats -->
    <section class="section" id="features" style="padding-top:0">
        <div class="container">
            <div class="sec-head"><span class="chip">✨ Everything you need</span><h2>Make more than ever before</h2><p>A modern earning platform built around fun, fair rewards and fast payouts.</p></div>
            <div class="grid grid-3" style="margin-bottom:40px">
                <div class="feature card"><div class="ico">🖱️</div><h3>Watch-to-Earn System</h3><p>Earn money by watching ads provided by advertisers — verified and timed.</p></div>
                <div class="feature card"><div class="ico">🤝</div><h3>Referral Program</h3><p>Earn commissions when the people you invite start earning too.</p></div>
                <div class="feature card"><div class="ico">📢</div><h3>Ad Posting System</h3><p>Advertisers can upload ads for users to watch — you control the reach.</p></div>
                <div class="feature card"><div class="ico">📊</div><h3>Dashboard &amp; Earnings</h3><p>See your total watch, referral earnings and withdrawable balance at a glance.</p></div>
                <div class="feature card"><div class="ico">₿</div><h3>Crypto Payouts</h3><p>Request payouts above the minimum — manually reviewed, paid fast.</p></div>
                <div class="feature card"><div class="ico">🛟</div><h3>24/7 Support</h3><p>Get help anytime with dedicated support around the clock.</p></div>
            </div>
            <div class="stats">
                <div class="stat card"><b class="grad-text">4.8★</b><span class="muted">User rating</span></div>
                <div class="stat card"><b class="grad-text">{{ number_format($stats['members']/1000,0) }}K+</b><span class="muted">Members</span></div>
                <div class="stat card"><b class="grad-text">${{ number_format($stats['paid']/1000000,1) }}M</b><span class="muted">Paid out</span></div>
                <div class="stat card"><b class="grad-text">{{ number_format($stats['watched']/1000000,1) }}M</b><span class="muted">Ads watched</span></div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section class="section" id="how" style="padding-top:0">
        <div class="container grid grid-2" style="align-items:center;gap:46px">
            <div>
                <span class="chip">⚡ Simple by design</span>
                <h2 style="margin-top:14px;font-size:clamp(28px,4vw,38px)">Sign up and secure your account</h2>
                <p>Create your account with your email. Complete the straightforward verification, then start earning the moment you join — no complicated setup.</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Create my account →</a>
            </div>
            <div class="card">
                <div class="step" style="display:flex;gap:14px;padding:16px 0;border-bottom:1px solid var(--border)"><span style="width:38px;height:38px;flex:0 0 38px;border-radius:11px;background:var(--grad-warm);color:#1a1205;display:grid;place-items:center;font-weight:800;font-family:var(--head)">1</span><div><b>Create your free account</b><p class="muted" style="margin:0">No upfront cost, no fees to join.</p></div></div>
                <div class="step" style="display:flex;gap:14px;padding:16px 0;border-bottom:1px solid var(--border)"><span style="width:38px;height:38px;flex:0 0 38px;border-radius:11px;background:var(--grad-warm);color:#1a1205;display:grid;place-items:center;font-weight:800;font-family:var(--head)">2</span><div><b>Watch ads &amp; play daily</b><p class="muted" style="margin:0">Earn from every ad, spin, keep your streak.</p></div></div>
                <div class="step" style="display:flex;gap:14px;padding:16px 0;border-bottom:1px solid var(--border)"><span style="width:38px;height:38px;flex:0 0 38px;border-radius:11px;background:var(--grad-warm);color:#1a1205;display:grid;place-items:center;font-weight:800;font-family:var(--head)">3</span><div><b>Grow with referrals</b><p class="muted" style="margin:0">Earn commissions on their earnings.</p></div></div>
                <div class="step" style="display:flex;gap:14px;padding:16px 0"><span style="width:38px;height:38px;flex:0 0 38px;border-radius:11px;background:var(--grad-warm);color:#1a1205;display:grid;place-items:center;font-weight:800;font-family:var(--head)">4</span><div><b>Cash out in crypto</b><p class="muted" style="margin:0">Withdraw whenever you hit the minimum.</p></div></div>
            </div>
        </div>
    </section>

    <!-- App showcase -->
    <section class="section showcase" style="padding-top:0">
        <div class="container">
            <div class="sec-head"><span class="chip">📱 Take a look</span><h2>Get a closer look at how our app works</h2><p>A glimpse of the intuitive design and powerful features that make earning effortless.</p></div>
            <div class="screens">
                <div class="screen"><div class="inner"><div class="hd"><span class="m">▲</span> Dashboard</div><div class="sbal"><small style="color:rgba(255,255,255,.85);font-size:9px">BALANCE</small><b>$8,042.50</b></div><div class="mini" style="margin:0"><div class="t"><small>Today</small><b style="font-size:14px">+$4.20</b></div><div class="t"><small>Streak</small><b style="font-size:14px">6 🔥</b></div></div></div></div>
                <div class="screen"><div class="inner"><div class="hd"><span class="m">▲</span> Spin</div><div class="sw"></div><div class="btn btn-primary btn-sm btn-block" style="margin-top:6px">SPIN</div></div></div>
                <div class="screen"><div class="inner"><div class="hd"><span class="m">▲</span> Live Payouts</div><div class="srow"><span class="sav">B</span><span style="flex:1">b***84 <small style="color:var(--muted)">BTC</small></span><b style="color:var(--green)">$1,204</b></div><div class="srow"><span class="sav">S</span><span style="flex:1">s***21 <small style="color:var(--muted)">USDT</small></span><b style="color:var(--green)">$318</b></div><div class="srow"><span class="sav">J</span><span style="flex:1">j***09 <small style="color:var(--muted)">SOL</small></span><b style="color:var(--green)">$76</b></div></div></div>
                <div class="screen"><div class="inner"><div class="hd"><span class="m">▲</span> Watch Ads</div><div class="srow" style="border:none;background:rgba(255,255,255,.03);border-radius:10px;padding:10px;margin-bottom:8px"><span>🎬 Watch &amp; Earn</span><b style="margin-left:auto;color:var(--green)">+$0.08</b></div><div class="srow" style="border:none;background:rgba(255,255,255,.03);border-radius:10px;padding:10px"><span>🌐 Visit Site</span><b style="margin-left:auto;color:var(--green)">+$0.05</b></div></div></div>
                <div class="screen"><div class="inner"><div class="hd"><span class="m">▲</span> Withdraw</div><label class="label" style="font-size:11px">Amount</label><div class="input" style="padding:9px;font-size:13px">$120.00</div><label class="label" style="font-size:11px;margin-top:8px">Method</label><div class="input" style="padding:9px;font-size:13px">USDT (TRC20)</div><div class="btn btn-primary btn-sm btn-block" style="margin-top:10px">Withdraw</div></div></div>
            </div>
        </div>
    </section>

    <!-- More ways to earn -->
    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="sec-head"><span class="chip">✨ New</span><h2>More ways to earn, every single day</h2><p>Three features that reward you for showing up and having fun.</p></div>
            <div class="grid grid-3">
                <div class="feature card center"><div class="sw" style="width:120px;height:120px;margin:0 auto 16px"></div><h3>Spin the Wheel</h3><p>A free spin every day for instant cash — plus a free ad reward every few spins.</p></div>
                <div class="feature card center"><div style="display:flex;gap:6px;justify-content:center;margin-bottom:16px">@for($i=1;$i<=5;$i++)<span style="width:26px;height:34px;border-radius:8px;display:grid;place-items:center;font-weight:800;font-size:11px;{{ $i<=3 ? 'background:var(--grad-warm);color:#1a1205' : 'background:rgba(255,255,255,.05);color:var(--muted)' }}">{{ $i }}</span>@endfor</div><h3>Daily Login Streak</h3><p>Check in daily to grow your streak and unlock bigger bonuses.</p></div>
                <div class="feature card center"><div style="margin-bottom:12px"><div class="payrow" style="max-width:220px;margin:0 auto 6px"><span class="av">B</span><span class="t">b***84<small>Bitcoin</small></span><span class="amt">$1,204</span></div><div class="payrow" style="max-width:220px;margin:0 auto"><span class="av">S</span><span class="t">s***21<small>USDT</small></span><span class="amt">$318</span></div></div><h3>Live Payouts Feed</h3><p>See real members get paid in real time. Full transparency.</p></div>
            </div>
        </div>
    </section>

    <!-- Earnings calculator + live payouts -->
    <section class="section" id="earn" style="padding-top:0">
        <div class="container">
            <div class="sec-head"><span class="chip">💸 Estimator</span><h2>See how much you could earn</h2><p>Pick a plan, drag the sliders, and watch your potential income update instantly.</p></div>
            <div class="grid grid-2" style="align-items:start">
                <div class="card">
                    <div class="field"><label class="label">Choose a plan</label><select class="input" id="cPlan"></select></div>
                    <div class="field"><div style="display:flex;justify-content:space-between"><label class="label">Ads watched per day</label><span class="chip" id="cAdsV">20</span></div><input type="range" class="range" id="cAds" min="0" max="50" value="20"></div>
                    <div class="field"><div style="display:flex;justify-content:space-between"><label class="label">Active referrals</label><span class="chip" id="cRefV">5</span></div><input type="range" class="range" id="cRef" min="0" max="200" value="5"></div>
                    <div class="results">
                        <div class="r"><small>Per Day</small><b id="cDay">$1.00</b></div>
                        <div class="r hl"><small>Per Month</small><b id="cMonth">$30</b></div>
                        <div class="r"><small>Per Year</small><b id="cYear">$365</b></div>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-block btn-lg">Start earning free →</a>
                    <p class="muted center" style="font-size:12px;margin-top:10px">Illustrative estimate based on average payouts.</p>
                </div>
                <div class="card">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px"><span class="pulse-dot"></span><b>Live Payouts</b><span class="muted" id="cTotal" style="margin-left:auto;font-size:13px"></span></div>
                    <div id="cFeed"><p class="muted">Loading recent payouts…</p></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="section" style="padding-top:0">
        <div class="container"><div class="cta-band">
            <h2>Start earning with every click</h2>
            <p style="max-width:480px;margin:0 auto 22px">Join thousands turning their free time into real income.</p>
            <a href="{{ route('register') }}" class="btn btn-lg" style="background:#fff;color:#c2410c">Create free account →</a>
        </div></div>
    </section>

    @push('scripts')
    <script>
        var plans = @json($calcPlans);
        if (!plans.length) plans = [{name:'Starter',limit:20,value:0.05}];
        var avg = 0.05, refBonus = 0.10;
        var $p = document.getElementById('cPlan'), $a = document.getElementById('cAds'), $r = document.getElementById('cRef');
        plans.forEach(function(p,i){ var o=document.createElement('option'); o.value=i; o.textContent=p.name+' — '+p.limit+' ads/day'; $p.appendChild(o); });
        function money(v){ return '$'+v.toLocaleString(undefined,{maximumFractionDigits:2}); }
        function calc(){
            var p=plans[$p.value]||plans[0], cap=p.limit||20;
            if(+$a.max!==cap){ $a.max=cap; if(+$a.value>cap)$a.value=cap; }
            var ads=+$a.value, refs=+$r.value, rate=p.value||avg;
            document.getElementById('cAdsV').textContent=ads; document.getElementById('cRefV').textContent=refs;
            var day=ads*rate + refs*refBonus;
            document.getElementById('cDay').textContent=money(day);
            document.getElementById('cMonth').textContent=money(day*30);
            document.getElementById('cYear').textContent=money(day*365);
        }
        $p.addEventListener('change',calc); $a.addEventListener('input',calc); $r.addEventListener('input',calc); calc();
        function initials(n){ return (n||'?')[0].toUpperCase(); }
        function loadFeed(){
            fetch('{{ route('withdraw.feed') }}').then(function(r){return r.json();}).then(function(res){
                if(res.status!=='success') return;
                document.getElementById('cTotal').textContent='Paid: '+res.total;
                var h=''; res.feed.slice(0,6).forEach(function(f){
                    h+='<div class="payrow"><span class="av">'+initials(f.user)+'</span><span class="t">'+f.user+'<small>'+f.method+' · '+f.ago+'</small></span><span class="amt">'+f.amount+'</span></div>';
                });
                document.getElementById('cFeed').innerHTML=h;
            }).catch(function(){});
        }
        loadFeed(); setInterval(loadFeed, 20000);
    </script>
    @endpush
</x-guest-layout>

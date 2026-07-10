<x-guest-layout>
    @push('head')
    <style>
        .hero { padding: 74px 0 90px; position: relative; overflow: hidden; }
        .hero-grid { display: grid; grid-template-columns: 1.05fr .95fr; gap: 46px; align-items: center; }
        .hero h1 { font-size: clamp(38px, 5.2vw, 62px); }
        .hero p.lead { font-size: 19px; max-width: 520px; }
        .hero-cta { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 28px; }
        .hero-note { margin-top: 18px; color: var(--faint); font-size: 13px; }
        @media (max-width: 900px){ .hero-grid { grid-template-columns: 1fr; } }

        .phone { width: 300px; max-width: 100%; margin: 0 auto; border-radius: 40px; padding: 12px;
            background: linear-gradient(160deg,#20222b,#0b0b0f); box-shadow: var(--shadow), 0 0 70px rgba(255,122,26,.2); animation: floaty 6s ease-in-out infinite; }
        .phone-screen { border-radius: 30px; overflow: hidden; background: var(--bg); padding: 18px 16px; }
        .balance { background: var(--grad); border-radius: 18px; padding: 20px; text-align: center; position: relative; overflow: hidden; }
        .balance small { color: rgba(255,255,255,.9); text-transform: uppercase; font-size: 10px; letter-spacing: .08em; }
        .balance h3 { font-size: 32px; color: #fff; margin: 4px 0 12px; }
        .balance .row { display: flex; gap: 8px; }
        .balance .b { flex: 1; padding: 9px; border-radius: 10px; font-weight: 700; font-size: 12px; }
        .mini { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 12px; }
        .mini .t { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 12px; }
        .mini .t small { color: var(--muted); font-size: 10px; } .mini .t b { display: block; font-size: 17px; margin-top: 3px; }

        .stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; margin-top: 8px; }
        @media (max-width: 700px){ .stats { grid-template-columns: 1fr 1fr; } }
        .stat { text-align: center; padding: 22px; }
        .stat b { font-family: var(--head); font-size: 30px; display: block; }

        .feature { padding: 26px; transition: transform .25s, border-color .25s; }
        .feature:hover { transform: translateY(-6px); border-color: rgba(255,122,26,.4); }
        .feature .ico { width: 52px; height: 52px; border-radius: 14px; display: grid; place-items: center; font-size: 24px; background: var(--grad-soft); border: 1px solid var(--border-2); margin-bottom: 16px; }
        .feature h3 { font-size: 20px; }

        .step { display: flex; gap: 16px; align-items: flex-start; padding: 20px 0; border-bottom: 1px solid var(--border); }
        .step .n { width: 42px; height: 42px; flex: 0 0 42px; border-radius: 12px; background: var(--grad-warm); color: #1a1205; display: grid; place-items: center; font-weight: 800; font-family: var(--head); }

        .plan { padding: 30px; text-align: center; position: relative; }
        .plan.pop { border-color: rgba(255,122,26,.5); box-shadow: 0 30px 60px -30px rgba(255,122,26,.5); }
        .plan .tag { position: absolute; top: -13px; left: 50%; transform: translateX(-50%); background: var(--grad-warm); color: #1a1205; font-size: 11px; font-weight: 800; padding: 5px 15px; border-radius: 999px; }
        .plan .price { font-family: var(--head); font-size: 40px; margin: 8px 0; }
        .plan ul { list-style: none; padding: 0; margin: 18px 0; text-align: left; }
        .plan li { padding: 9px 0; border-bottom: 1px solid var(--border); color: var(--muted); font-size: 14px; }
        .plan li::before { content: "✓"; color: var(--brand-2); font-weight: 800; margin-right: 9px; }

        .cta-band { background: var(--grad); border-radius: 28px; padding: 56px; text-align: center; position: relative; overflow: hidden; }
        .cta-band h2 { color: #fff; font-size: clamp(28px,4vw,44px); }
        .cta-band p { color: rgba(255,255,255,.9); }
    </style>
    @endpush

    <section class="hero">
        <div class="container hero-grid">
            <div>
                <span class="chip">💸 Get paid to watch ads</span>
                <h1 style="margin-top:18px">Turn every click into <span class="grad-text">real cash</span></h1>
                <p class="lead">Join thousands earning daily. Watch ads, spin the wheel, keep your streak and cash out in crypto — fast, secure, and free to start.</p>
                <div class="hero-cta">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Start earning free →</a>
                    <a href="#features" class="btn btn-ghost btn-lg">How it works</a>
                </div>
                <div class="hero-note">✓ No fees to join &nbsp;·&nbsp; ✓ Manual crypto withdrawals &nbsp;·&nbsp; ✓ 24/7 support</div>
            </div>
            <div>
                <div class="phone">
                    <div class="phone-screen">
                        <div class="balance">
                            <small>Available Balance</small>
                            <h3>$1,284.50</h3>
                            <div class="row"><span class="b" style="background:rgba(255,255,255,.18);color:#fff">Watch ads</span><span class="b" style="background:#fff;color:#c2410c">Withdraw</span></div>
                        </div>
                        <div class="mini">
                            <div class="t"><small>Today</small><b style="color:var(--green)">+$4.20</b></div>
                            <div class="t"><small>Streak</small><b>6 days 🔥</b></div>
                            <div class="t"><small>Referrals</small><b>18</b></div>
                            <div class="t"><small>Spins left</small><b>1 🎡</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="stats">
            <div class="stat card"><b class="grad-text">250K+</b><span class="muted">Members</span></div>
            <div class="stat card"><b class="grad-text">$5.8M</b><span class="muted">Paid out</span></div>
            <div class="stat card"><b class="grad-text">1.2M</b><span class="muted">Ads watched</span></div>
            <div class="stat card"><b class="grad-text">4.8★</b><span class="muted">User rating</span></div>
        </div>
    </div>

    <section class="section" id="features">
        <div class="container">
            <div class="center mx-auto" style="max-width:600px;margin-bottom:48px">
                <span class="chip">✨ Everything you need</span>
                <h2 style="margin-top:16px;font-size:clamp(30px,4vw,42px)">More ways to earn, every day</h2>
                <p>A modern earning platform built around fun, fair rewards and fast payouts.</p>
            </div>
            <div class="grid grid-3">
                <div class="feature card"><div class="ico">🖱️</div><h3>Watch &amp; Earn</h3><p>Get paid for every ad you watch. Simple, timed, and verified — your balance grows with every view.</p></div>
                <div class="feature card"><div class="ico">🎡</div><h3>Spin the Wheel</h3><p>A free daily spin for instant cash prizes — and a free ad reward every few spins.</p></div>
                <div class="feature card"><div class="ico">🔥</div><h3>Daily Streak</h3><p>Check in every day to grow your streak. The longer the streak, the bigger the bonus.</p></div>
                <div class="feature card"><div class="ico">🤝</div><h3>Referrals</h3><p>Invite friends and earn commissions on their activity — passive income that compounds.</p></div>
                <div class="feature card"><div class="ico">₿</div><h3>Crypto Payouts</h3><p>Withdraw your earnings in crypto. Manually reviewed for security, processed fast.</p></div>
                <div class="feature card"><div class="ico">🛡️</div><h3>Safe &amp; Fair</h3><p>Anti-fraud checks, transparent balances, and a live payouts feed you can actually trust.</p></div>
            </div>
        </div>
    </section>

    <section class="section" id="earn" style="padding-top:0">
        <div class="container grid grid-2" style="align-items:center;gap:46px">
            <div class="card">
                <div class="step"><span class="n">1</span><div><h3 style="font-size:19px">Create your free account</h3><p style="margin:0">Sign up in seconds — no upfront cost, no fees to join.</p></div></div>
                <div class="step"><span class="n">2</span><div><h3 style="font-size:19px">Watch ads &amp; play daily</h3><p style="margin:0">Earn from every ad, spin the wheel, and keep your streak alive.</p></div></div>
                <div class="step"><span class="n">3</span><div><h3 style="font-size:19px">Grow with referrals</h3><p style="margin:0">Invite friends and earn commissions on their earnings.</p></div></div>
                <div class="step" style="border:none"><span class="n">4</span><div><h3 style="font-size:19px">Cash out in crypto</h3><p style="margin:0">Request a withdrawal and get paid to your wallet after a quick review.</p></div></div>
            </div>
            <div>
                <span class="chip">⚡ Simple by design</span>
                <h2 style="margin-top:16px;font-size:clamp(28px,4vw,40px)">From sign-up to payout in four steps</h2>
                <p>No complicated setup. Start earning the moment you join, and withdraw whenever you hit the minimum.</p>
                <a href="{{ route('register') }}" class="btn btn-primary">Create my account →</a>
            </div>
        </div>
    </section>

    <section class="section" id="plans" style="padding-top:0">
        <div class="container">
            <div class="center mx-auto" style="max-width:560px;margin-bottom:44px">
                <span class="chip">👑 Membership</span>
                <h2 style="margin-top:16px;font-size:clamp(30px,4vw,42px)">Pick your earning plan</h2>
                <p>Upgrade any time to unlock higher daily limits and better payouts.</p>
            </div>
            <div class="grid grid-3">
                <div class="plan card"><h3>Starter</h3><div class="price">Free</div><ul><li>10 ads / day</li><li>Daily spin</li><li>Standard support</li></ul><a href="{{ route('register') }}" class="btn btn-ghost btn-block">Get started</a></div>
                <div class="plan card pop"><span class="tag">POPULAR</span><h3>Pro</h3><div class="price grad-text">$25</div><ul><li>50 ads / day</li><li>Higher payouts</li><li>Priority support</li><li>Lower withdraw minimum</li></ul><a href="{{ route('register') }}" class="btn btn-primary btn-block">Choose Pro</a></div>
                <div class="plan card"><h3>Elite</h3><div class="price">$99</div><ul><li>Unlimited ads</li><li>Best payout rate</li><li>VIP support</li></ul><a href="{{ route('register') }}" class="btn btn-ghost btn-block">Go Elite</a></div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:0">
        <div class="container">
            <div class="cta-band">
                <h2>Ready to start earning?</h2>
                <p style="max-width:480px;margin:0 auto 22px">Join today and get your first spin, streak bonus and welcome rewards instantly.</p>
                <a href="{{ route('register') }}" class="btn btn-lg" style="background:#fff;color:#c2410c">Create free account →</a>
            </div>
        </div>
    </section>
</x-guest-layout>

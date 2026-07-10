@props(['title' => 'Dashboard'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .app { display: grid; grid-template-columns: 264px 1fr; min-height: 100vh; }
        .side { background: linear-gradient(180deg, var(--surface), var(--bg-2)); border-right: 1px solid var(--border); padding: 20px 16px; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .side .brand { margin-bottom: 22px; }
        .menu { list-style: none; margin: 0; padding: 0; display: grid; gap: 4px; }
        .menu a { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; color: var(--muted); font-weight: 600; font-size: 15px; }
        .menu a:hover { background: rgba(255,255,255,.05); color: var(--text); }
        .menu a.active { background: var(--grad-warm); color: #1a1205; box-shadow: var(--glow); }
        .menu .ico { width: 22px; text-align: center; }
        .main { padding: 0; }
        .topbar { display: flex; align-items: center; gap: 16px; padding: 16px 30px; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: rgba(8,11,20,.7); backdrop-filter: blur(12px); z-index: 20; }
        .topbar .bal { margin-left: auto; display: flex; align-items: center; gap: 10px; padding: 9px 16px; border-radius: 999px; background: var(--grad-soft); border: 1px solid var(--border-2); font-weight: 800; }
        .topbar .bal small { color: var(--muted); font-weight: 600; }
        .content { padding: 30px; }
        .side-toggle { display: none; }
        @media (max-width: 900px) {
            .app { grid-template-columns: 1fr; }
            .side { position: fixed; left: 0; top: 0; width: 280px; z-index: 60; transform: translateX(-100%); transition: transform .25s; }
            #nav:checked ~ .app .side { transform: none; }
            .side-toggle { display: inline-grid; place-items: center; width: 42px; height: 42px; border-radius: 11px; background: var(--grad-warm); color:#1a1205; cursor: pointer; font-size: 20px; }
            #nav:checked ~ .backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.5); backdrop-filter: blur(3px); z-index: 55; }
        }
    </style>
    @stack('head')
</head>
<body>
    <input type="checkbox" id="nav" hidden>
    <label for="nav" class="backdrop"></label>
    <div class="app">
        <aside class="side">
            <a href="{{ route('dashboard') }}" class="brand"><span class="brand-mark">▲</span> {{ config('app.name') }}</a>
            @php $r = request()->routeIs(...); @endphp
            <ul class="menu">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="ico">📊</span> Dashboard</a></li>
                <li><a href="{{ route('ads.index') }}" class="{{ request()->routeIs('ads.*') ? 'active' : '' }}"><span class="ico">🖱️</span> Watch Ads</a></li>
                <li><a href="{{ route('rewards.index') }}" class="{{ request()->routeIs('rewards.*') ? 'active' : '' }}"><span class="ico">🎡</span> Spin &amp; Rewards</a></li>
                <li><a href="{{ route('deposits.index') }}" class="{{ request()->routeIs('deposits.*') ? 'active' : '' }}"><span class="ico">💳</span> Deposit</a></li>
                <li><a href="{{ route('withdrawals.index') }}" class="{{ request()->routeIs('withdrawals.*') ? 'active' : '' }}"><span class="ico">🏧</span> Withdraw</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="menu-logout" style="all:unset;display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:12px;color:var(--muted);font-weight:600;cursor:pointer;width:100%"><span class="ico">🚪</span> Logout</button>
                    </form>
                </li>
            </ul>
        </aside>

        <main class="main">
            <header class="topbar">
                <label for="nav" class="side-toggle">☰</label>
                <h3 style="margin:0;font-size:19px">{{ $title }}</h3>
                <div class="bal"><small>Balance</small> ${{ number_format(auth()->user()->balance, 2) }}</div>
            </header>
            <div class="content">
                @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                @if (session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif
                {{ $slot }}
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

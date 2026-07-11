@props(['title' => 'Admin'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} — Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        .app { display: grid; grid-template-columns: 250px 1fr; min-height: 100vh; }
        .side { background: linear-gradient(180deg, var(--surface), var(--bg-2)); border-right: 1px solid var(--border); padding: 18px 14px; position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .menu { list-style: none; margin: 12px 0 0; padding: 0; display: grid; gap: 3px; }
        .menu a { display: flex; align-items: center; gap: 11px; padding: 10px 13px; border-radius: 11px; color: var(--muted); font-weight: 600; font-size: 14px; }
        .menu a:hover { background: rgba(255,255,255,.05); color: var(--text); }
        .menu a.active { background: var(--grad-warm); color: #1a1205; }
        .topbar { display: flex; align-items: center; gap: 16px; padding: 15px 28px; border-bottom: 1px solid var(--border); position: sticky; top: 0; background: rgba(8,11,20,.7); backdrop-filter: blur(12px); z-index: 20; }
        .content { padding: 28px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 11px 10px; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .b-pending { background: rgba(251,191,36,.15); color: #fbbf24; } .b-ok { background: rgba(52,211,153,.15); color: var(--green); } .b-rej { background: rgba(244,114,182,.15); color: var(--pink); }
        .grid-a { display: grid; gap: 22px; }
        @media (max-width: 900px){ .app { grid-template-columns: 1fr; } .side { display: none; } }
    </style>
    @stack('head')
</head>
<body>
    <div class="app">
        <aside class="side">
            <a href="{{ route('admin.dashboard') }}" class="brand"><span class="brand-mark">▲</span> Admin</a>
            <ul class="menu">
                @php $ri = fn($p) => request()->routeIs($p) ? 'active' : ''; @endphp
                <li><a href="{{ route('admin.dashboard') }}" class="{{ $ri('admin.dashboard') }}">📊 Dashboard</a></li>
                <li><a href="{{ route('admin.deposits') }}" class="{{ $ri('admin.deposits*') }}">💳 Deposits</a></li>
                <li><a href="{{ route('admin.withdrawals') }}" class="{{ $ri('admin.withdrawals*') }}">🏧 Withdrawals</a></li>
                <li><a href="{{ route('admin.ads') }}" class="{{ $ri('admin.ads*') }}">🖱️ Ads</a></li>
                <li><a href="{{ route('admin.plans') }}" class="{{ $ri('admin.plans*') }}">👑 Plans</a></li>
                <li><a href="{{ route('admin.crypto') }}" class="{{ $ri('admin.crypto*') }}">₿ Crypto Wallets</a></li>
                <li><a href="{{ route('admin.users') }}" class="{{ $ri('admin.users*') }}">👥 Users</a></li>
                <li><a href="{{ route('admin.templates') }}" class="{{ $ri('admin.templates*') }}">✉️ Email Templates</a></li>
                <li><a href="{{ route('admin.account') }}" class="{{ $ri('admin.account*') }}">🔑 My Account</a></li>
                <li><a href="{{ route('admin.settings') }}" class="{{ $ri('admin.settings*') }}">⚙️ Settings</a></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">@csrf
                        <button style="all:unset;display:flex;gap:11px;padding:10px 13px;border-radius:11px;color:var(--muted);font-weight:600;cursor:pointer;width:100%">🚪 Logout</button>
                    </form>
                </li>
            </ul>
        </aside>
        <main>
            <header class="topbar"><h3 style="margin:0;font-size:18px">{{ $title }}</h3></header>
            <div class="content">
                @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                @if (session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif
                @if ($errors->any()) <div class="alert alert-error">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div> @endif
                {{ $slot }}
            </div>
        </main>
    </div>
    @stack('scripts')
</body>
</html>

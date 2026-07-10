<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }} — Get paid to watch ads</title>
    <meta name="description" content="Earn real money every day by watching ads, spinning the wheel, keeping your streak and referring friends. Fast manual crypto payouts.">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('head')
</head>
<body>
    <nav class="nav">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="brand">
                <span class="brand-mark">▲</span> {{ config('app.name') }}
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}#features" class="link">Features</a>
                <a href="{{ route('home') }}#earn" class="link">Earnings</a>
                <a href="{{ route('home') }}#plans" class="link">Plans</a>
                <a href="{{ route('home') }}#faq" class="link">FAQ</a>
            </div>
            <div class="nav-cta">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-sm">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Get started</a>
                @endauth
            </div>
        </div>
    </nav>

    {{ $slot }}

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div style="max-width:320px">
                    <a href="{{ route('home') }}" class="brand" style="margin-bottom:14px"><span class="brand-mark">▲</span> {{ config('app.name') }}</a>
                    <p>Earn real income online through pay-per-watch advertising, daily rewards and referrals. Fast, secure, crypto payouts.</p>
                </div>
                <div><h5>Platform</h5><a href="{{ route('home') }}#features">How it works</a><a href="{{ route('home') }}#plans">Plans</a><a href="{{ route('register') }}">Sign up</a></div>
                <div><h5>Earn</h5><a href="{{ route('home') }}#earn">Watch &amp; earn</a><a href="{{ route('home') }}#features">Spin &amp; streak</a><a href="{{ route('home') }}#features">Referrals</a></div>
                <div><h5>Legal</h5><a href="#">Privacy policy</a><a href="#">Payment policy</a><a href="#">Terms</a></div>
            </div>
            <div class="footer-bottom">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>

<x-app-layout title="Watch Ads">
    @push('head')
    <style>
        .adgrid { display: grid; grid-template-columns: repeat(3,1fr); gap: 18px; }
        @media (max-width: 900px){ .adgrid { grid-template-columns: 1fr 1fr; } }
        @media (max-width: 560px){ .adgrid { grid-template-columns: 1fr; } }
        .adcard { padding: 0; overflow: hidden; transition: transform .2s, border-color .2s; }
        .adcard:hover { transform: translateY(-4px); border-color: rgba(255,122,26,.4); }
        .adcard .top { height: 96px; display: grid; place-items: center; font-size: 34px; background: linear-gradient(135deg,#1a1030,#12203a); }
        .adcard .b { padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .adcard .b h4 { margin: 0; font-size: 15px; }
        .reward-badge { color: var(--green); font-weight: 800; font-size: 14px; white-space: nowrap; }
        .limit-banner { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:22px; }
    </style>
    @endpush

    <div class="card limit-banner">
        <div>
            <h3 style="margin:0;font-size:18px">Watch ads &amp; earn</h3>
            <p style="margin:4px 0 0">You have <b style="color:var(--brand-2)">{{ $remaining }}</b> ad{{ $remaining == 1 ? '' : 's' }} left to watch today.</p>
        </div>
        <span class="chip"><x-icon name="flame" size="15" /> Daily limit: {{ $user->effectiveDailyLimit() }}</span>
    </div>

    @if ($remaining <= 0)
        <div class="card center" style="padding:50px">
            <div style="color:var(--green)"><x-icon name="circle-check" size="44" /></div>
            <h3>You're all caught up!</h3>
            <p>You've watched all your ads for today. Come back tomorrow for more — or upgrade your plan for a higher daily limit.</p>
            <a href="{{ route('rewards.index') }}" class="btn btn-primary">Try the spin wheel <x-icon name="ferris-wheel" size="16" /></a>
        </div>
    @elseif ($ads->isEmpty())
        <div class="card center" style="padding:50px">
            <div style="color:var(--muted)"><x-icon name="inbox" size="44" /></div>
            <h3>No ads available right now</h3>
            <p>Check back soon — new ads are added throughout the day.</p>
        </div>
    @else
        <div class="adgrid">
            @foreach ($ads as $ad)
                <a href="{{ route('ads.show', $ad) }}" class="card adcard" target="_blank" style="text-decoration:none;color:inherit">
                    <div class="top"><x-icon name="{{ [1=>'globe',2=>'image',3=>'megaphone',4=>'video'][$ad->type] ?? 'mouse-pointer-click' }}" size="34" /></div>
                    <div class="b">
                        <h4>{{ $ad->title }}</h4>
                        <span class="reward-badge">+${{ number_format($ad->reward, 2) }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</x-app-layout>

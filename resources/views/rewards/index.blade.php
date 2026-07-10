<x-app-layout title="Spin & Rewards">
    @php
        $n = count($segments); $seg = 360 / $n;
        $cols = ['#7c1f6e','#3a1e6e','#8a3d1a','#5a2ea8','#a3521a','#42277a','#7c1f6e','#5a2ea8'];
        $stops = [];
        foreach ($segments as $i => $s) { $stops[] = $cols[$i % count($cols)].' '.($i*$seg).'deg '.(($i+1)*$seg).'deg'; }
        $conic = 'conic-gradient('.implode(',', $stops).')';
    @endphp
    @push('head')
    <style>
        .rw-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
        @media (max-width: 900px){ .rw-grid { grid-template-columns: 1fr; } }
        .wheel-wrap { position: relative; width: 300px; max-width: 100%; aspect-ratio: 1; margin: 18px auto; }
        .wheel { width: 100%; height: 100%; border-radius: 50%; border: 8px solid rgba(255,255,255,.08); box-shadow: 0 0 0 6px rgba(255,122,26,.25), var(--shadow); transition: transform 5s cubic-bezier(.15,.85,.25,1); position: relative; }
        .wheel .lab { position: absolute; inset: 0; display: flex; justify-content: center; padding-top: 16px; }
        .wheel .lab span { color: #fff; font-weight: 800; font-size: 12px; text-shadow: 0 1px 3px rgba(0,0,0,.6); }
        .pointer { position: absolute; top: -6px; left: 50%; transform: translateX(-50%); width: 0; height: 0; z-index: 3; border-left: 13px solid transparent; border-right: 13px solid transparent; border-top: 22px solid var(--brand); filter: drop-shadow(0 3px 5px rgba(0,0,0,.5)); }
        .hub { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 62px; height: 62px; border-radius: 50%; z-index: 2; display: grid; place-items: center; background: var(--grad-warm); color: #1a1205; font-weight: 800; border: 3px solid rgba(255,255,255,.25); box-shadow: var(--glow); cursor: pointer; }
        .hub.off { filter: grayscale(.6) brightness(.7); cursor: not-allowed; }
        .streak-days { display: flex; gap: 8px; margin: 16px 0; }
        .streak-days .d { flex: 1; text-align: center; padding: 12px 4px; border-radius: 12px; background: rgba(255,255,255,.03); border: 1px solid var(--border); color: var(--muted); font-weight: 700; font-size: 12px; }
        .streak-days .d.on { background: var(--grad-warm); color: #1a1205; border: none; }
        .streak-days .d b { display: block; font-size: 15px; }
        .milestone { display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid var(--border); }
    </style>
    @endpush

    <div class="rw-grid">
        <!-- Spin -->
        <div class="card center">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                <h3 style="margin:0;font-size:18px">Spin the Wheel</h3>
                <span class="chip">🎟️ {{ $canSpin ? '1 free spin' : 'Back tomorrow' }}</span>
            </div>
            <div class="wheel-wrap">
                <div class="pointer"></div>
                <div class="wheel" id="wheel" style="background: {{ $conic }};">
                    @foreach ($segments as $i => $s)
                        <div class="lab" style="transform: rotate({{ $i*$seg + $seg/2 }}deg)"><span style="transform: rotate(90deg)">{{ $s['label'] }}</span></div>
                    @endforeach
                </div>
                <button id="spin" class="hub {{ $canSpin ? '' : 'off' }}" {{ $canSpin ? '' : 'disabled' }}>SPIN</button>
            </div>
            <p id="spinres" class="muted">{{ $canSpin ? 'Tap SPIN to try your luck!' : 'You already spun today.' }}</p>
            <p class="muted" style="font-size:13px">🎟️ Free Ads: <b id="freeads" style="color:var(--brand-2)">{{ (int) $user->free_ad_credits }}</b> · Win 1 Free Ad every {{ $freeAdEvery }} spins</p>
        </div>

        <!-- Streak -->
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                <h3 style="margin:0;font-size:18px">Daily Streak</h3>
                <span class="chip">🔥 {{ (int) $user->streak_count }} days</span>
            </div>
            @php $dots = ($user->streak_count % 7 == 0 && $user->streak_count > 0) ? 7 : $user->streak_count % 7; @endphp
            <div class="streak-days">
                @for ($i=1;$i<=7;$i++)<div class="d {{ $i <= $dots ? 'on' : '' }}"><b>{{ $i }}</b>Day</div>@endfor
            </div>
            <form method="POST" action="{{ route('rewards.checkin') }}">@csrf
                <button class="btn btn-primary btn-block btn-lg" {{ $canCheckIn ? '' : 'disabled' }}>
                    {{ $canCheckIn ? 'Claim today\'s bonus (+$'.number_format($nextReward,2).')' : 'Already claimed — back tomorrow' }}
                </button>
            </form>
            <h5 style="margin:20px 0 6px">Streak milestones</h5>
            @foreach ($tiers as $day => $amt)
                <div class="milestone"><span>🏅 Day {{ $day }}+</span><b style="color:var(--green)">${{ number_format($amt,2) }}</b></div>
            @endforeach
        </div>
    </div>

    @push('scripts')
    <script>
        (function(){
            var n = {{ $n }}, seg = 360/n, spins = 0, busy = false;
            var wheel = document.getElementById('wheel'), btn = document.getElementById('spin'), res = document.getElementById('spinres');
            if (!btn) return;
            btn.addEventListener('click', function(){
                if (busy || btn.disabled) return; busy = true; res.textContent = 'Spinning…';
                fetch('{{ route('rewards.spin') }}', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'} })
                .then(function(r){ return r.json().then(function(d){ return {ok:r.ok, d:d}; }); })
                .then(function(o){
                    if (!o.ok){ busy=false; res.textContent = o.d.message || 'Error'; return; }
                    var d = o.d, target = d.index*seg + seg/2; spins += 6;
                    wheel.style.transform = 'rotate(' + (spins*360 - target) + 'deg)';
                    setTimeout(function(){
                        var prize = d.type === 'free_ad' ? '1 Free Ad 🎟️' : d.label;
                        res.innerHTML = '🎉 You won <b style="color:var(--green)">' + prize + '</b>!';
                        document.getElementById('freeads').textContent = d.free_ad_credits;
                        btn.classList.add('off'); btn.disabled = true;
                    }, 5100);
                });
            });
        })();
    </script>
    @endpush
</x-app-layout>

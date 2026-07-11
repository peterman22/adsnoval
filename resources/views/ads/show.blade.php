<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Watch &amp; Earn — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <style>
        body { display: flex; flex-direction: column; }
        .aw-top { position: sticky; top: 0; z-index: 30; display: flex; align-items: center; gap: 16px; padding: 12px 22px; background: rgba(8,11,20,.75); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); }
        .aw-reward { margin-left: auto; display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 999px; background: var(--grad-soft); border: 1px solid var(--border-2); font-weight: 700; }
        .aw-reward b { color: var(--green); }
        #bar-wrap { height: 6px; background: rgba(255,255,255,.06); }
        #bar { width: 0; height: 6px; background: var(--grad-warm); box-shadow: 0 0 14px rgba(255,122,26,.7); transition: width .2s linear; }
        .aw-stage { flex: 1; display: flex; justify-content: center; padding: 26px 18px 130px; }
        .aw-card { width: 100%; max-width: 1040px; overflow: hidden; padding: 0; }
        .aw-bar { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-bottom: 1px solid var(--border); background: rgba(255,255,255,.02); }
        .dots span { width: 11px; height: 11px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .dots span:nth-child(1){background:#ff5f57} .dots span:nth-child(2){background:#febc2e} .dots span:nth-child(3){background:#28c840}
        .aw-label { color: var(--muted); font-size: 13px; font-weight: 600; }
        .aw-body { position: relative; height: clamp(340px, 62vh, 700px); background: #060912; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .aw-body iframe { width: 100%; height: 100%; border: 0; }
        .aw-video { width: 100%; max-width: 900px; aspect-ratio: 16/9; position: relative; }
        .aw-video iframe { position: absolute; inset: 0; }
        .aw-body img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .aw-actionbar { position: fixed; left: 0; right: 0; bottom: 0; z-index: 30; background: rgba(8,11,20,.92); backdrop-filter: blur(12px); border-top: 1px solid var(--border); padding: 12px 18px; }
        .aw-inner { max-width: 1040px; margin: 0 auto; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .aw-status { display: flex; align-items: center; gap: 10px; color: var(--muted); font-weight: 600; }
        .aw-cap { display: none; align-items: center; gap: 8px; }
        .aw-cap.show { display: flex; }
        .aw-cap input { width: 66px; text-align: center; }
        .aw-actions { margin-left: auto; display: flex; gap: 10px; }
        #go[disabled] { opacity: .5; cursor: not-allowed; }
    </style>
</head>
<body>
    <header class="aw-top">
        <a href="{{ route('ads.index') }}" class="brand" style="font-size:18px"><img src="{{ asset('assets/img/logo.png') }}" class="brand-logo" alt="{{ config('app.name') }}"> Watch &amp; Earn</a>
        <div class="aw-reward"><x-icon name="gift" /> Reward <b>${{ number_format($ad->reward, 2) }}</b></div>
    </header>
    <div id="bar-wrap"><div id="bar"></div></div>

    <main class="aw-stage">
        <div class="card aw-card">
            <div class="aw-bar">
                <span class="dots"><span></span><span></span><span></span></span>
                <span class="aw-label">Sponsored · {{ $ad->title }}</span>
                <span style="margin-left:auto;color:var(--green);font-size:12px;font-weight:800"><span class="pulse-dot" style="display:inline-block;vertical-align:middle;margin-right:6px"></span>WATCHING</span>
            </div>
            <div class="aw-body">
                @if ($ad->type == 2)
                    <img src="{{ $ad->body }}" alt="ad">
                @elseif ($ad->type == 3)
                    {!! $ad->body !!}
                @elseif ($ad->type == 4)
                    <div class="aw-video"><video id="adVideo" src="{{ $ad->body }}" autoplay muted loop playsinline controls controlslist="nodownload noremoteplayback noplaybackrate" disablepictureinpicture oncontextmenu="return false" style="width:100%;height:100%;object-fit:contain;background:#000"></video></div>
                @else
                    <iframe src="{{ $ad->body }}"></iframe>
                @endif
            </div>
        </div>
    </main>

    <footer class="aw-actionbar">
        <form id="form" method="POST" action="{{ route('ads.confirm', $ad) }}" class="aw-inner">
            @csrf
            <input type="hidden" name="started_at" value="{{ $startedAt }}">
            <input type="hidden" name="sig" value="{{ $sig }}">
            <div class="aw-status"><span id="status">Watch the ad to unlock your reward…</span></div>
            <span class="aw-cap" id="cap">
                <span class="muted" style="font-weight:800">{{ $a }} + {{ $b }} =</span>
                <input class="input" type="number" name="answer" id="answer" placeholder="?" required>
            </span>
            <div class="aw-actions">
                <button type="submit" id="go" class="btn btn-primary" disabled>Confirm &amp; Earn</button>
                <a href="{{ route('ads.index') }}" class="btn btn-ghost">Close</a>
            </div>
        </form>
    </footer>

    <script>
        (function(){
            var duration = {{ (int) $ad->duration }};
            var bar = document.getElementById('bar'), status = document.getElementById('status');
            var cap = document.getElementById('cap'), go = document.getElementById('go');
            var start = Date.now();
            var t = setInterval(function(){
                var pct = Math.min(100, ((Date.now()-start)/1000/duration)*100);
                bar.style.width = pct + '%';
                if (pct >= 100){
                    clearInterval(t);
                    var v = document.getElementById('adVideo');
                    if (v){ v.loop = false; v.pause(); }   // auto-stop the video when time's up
                    cap.classList.add('show');
                    status.textContent = 'Solve the sum to claim your reward';
                    go.removeAttribute('disabled');
                }
            }, 150);
        })();
    </script>
</body>
</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" type="image/png" href="{{ siteFavicon() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    @php
        $activeTemplateTrue = activeTemplate(true);
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <script src="{{ asset('assets/global/js/jquery-3.7.1.min.js') }}"></script>

    <title>{{ gs()->sitename(__($pageTitle)) }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    {{-- Anti-cheat: blur/replace the page if the user switches away --}}
    <script>
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.body.innerHTML = `
                    <div class="leave-msg">
                        <div class="leave-msg__icon">&#9888;</div>
                        <h3>@lang('Session paused')</h3>
                        <p>@lang('You left the ad. Please reopen it from your ads list to earn.')</p>
                    </div>`;
            }
        });
    </script>

    <style>
        :root {
            --bg: #0a0e1a; --surface: #141b2d; --surface-2: #1a2236;
            --border: rgba(255,255,255,.08); --border-2: rgba(255,255,255,.14);
            --accent: #ff9142; --primary: #7c3aed; --green: #34d399; --red: #f472b6;
            --text: #e8edf9; --muted: #8b96ab;
            --grad: linear-gradient(135deg, #7c3aed 0%, #9333ea 45%, #f97316 100%);
            --grad-soft: linear-gradient(135deg, rgba(124,58,237,.18), rgba(249,115,22,.18));
        }
        * { box-sizing: border-box; }
        body {
            margin: 0; min-height: 100vh; color: var(--text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background:
                radial-gradient(1000px 500px at 85% -10%, rgba(124,58,237,.18), transparent 60%),
                radial-gradient(800px 400px at -10% 10%, rgba(249,115,22,.14), transparent 55%),
                var(--bg);
            display: flex; flex-direction: column;
        }

        /* ---------- Top bar ---------- */
        .ad-topbar {
            position: sticky; top: 0; z-index: 30;
            display: flex; align-items: center; gap: 16px;
            padding: 12px 20px;
            background: rgba(12,17,32,.75); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .ad-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; letter-spacing: -.01em; }
        .ad-brand img { height: 30px; width: 30px; border-radius: 8px; }
        .ad-title { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--muted); font-weight: 600; }
        .ad-reward {
            margin-left: auto; display: flex; align-items: center; gap: 8px;
            padding: 8px 16px; border-radius: 999px;
            background: var(--grad-soft); border: 1px solid var(--border-2);
            font-weight: 700; font-size: 14px; white-space: nowrap;
        }
        .ad-reward b { color: var(--green); }

        /* ---------- Progress ---------- */
        #myProgress { width: 100%; height: 6px; background: rgba(255,255,255,.06); overflow: hidden; }
        #myBar {
            width: 0%; height: 6px; line-height: 6px; font-size: 0; color: transparent;
            background: var(--grad); transition: width .18s linear;
            box-shadow: 0 0 14px rgba(124,58,237,.7);
        }

        /* ---------- Ad stage ---------- */
        .ad-stage { flex: 1; display: flex; justify-content: center; align-items: flex-start; padding: 26px 18px 140px; }
        .ad-card {
            width: 100%; max-width: 1040px;
            background: linear-gradient(180deg, var(--surface), var(--surface-2));
            border: 1px solid var(--border); border-radius: 20px; overflow: hidden;
            box-shadow: 0 40px 90px -40px rgba(0,0,0,.9);
        }
        .ad-card__bar {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-bottom: 1px solid var(--border);
            background: rgba(255,255,255,.02);
        }
        .ad-card__dots { display: flex; gap: 6px; }
        .ad-card__dots span { width: 11px; height: 11px; border-radius: 50%; background: rgba(255,255,255,.14); }
        .ad-card__dots span:nth-child(1) { background: #ff5f57; } .ad-card__dots span:nth-child(2) { background: #febc2e; } .ad-card__dots span:nth-child(3) { background: #28c840; }
        .ad-card__label { color: var(--muted); font-size: 13px; font-weight: 600; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .ad-card__live {
            margin-left: auto; display: inline-flex; align-items: center; gap: 7px;
            font-size: 12px; font-weight: 800; color: var(--green); letter-spacing: .04em;
        }
        .ad-card__live .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green); box-shadow: 0 0 0 0 rgba(52,211,153,.7); animation: pulse 1.6s infinite; }
        @keyframes pulse { 0%{box-shadow:0 0 0 0 rgba(52,211,153,.6);} 70%{box-shadow:0 0 0 9px rgba(52,211,153,0);} 100%{box-shadow:0 0 0 0 rgba(52,211,153,0);} }

        .ad-card__body {
            position: relative; height: clamp(340px, 64vh, 720px);
            background: #0b0f1c; display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .ad-embed { width: 100%; height: 100%; border: 0; display: block; }
        .ad-image { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; padding: 18px; }
        .ad-image img { max-width: 100%; max-height: 100%; object-fit: contain; border-radius: 8px; }
        .ad-script { width: 100%; max-height: 100%; overflow: auto; padding: 26px; }
        .ad-video { position: relative; width: 100%; max-width: 960px; height: auto; aspect-ratio: 16 / 9; margin: auto; }
        .ad-video iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; border-radius: 8px; }

        /* ---------- Action bar ---------- */
        .ad-actionbar {
            position: fixed; left: 0; right: 0; bottom: 0; z-index: 30;
            background: rgba(12,17,32,.9); backdrop-filter: blur(12px);
            border-top: 1px solid var(--border); padding: 12px 18px;
        }
        .ad-actionbar__inner { max-width: 1040px; margin: 0 auto; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
        .ad-status { display: flex; align-items: center; gap: 10px; color: var(--muted); font-weight: 600; }
        .ad-status__icon {
            width: 38px; height: 38px; flex: 0 0 38px; border-radius: 11px; display: grid; place-items: center;
            background: var(--grad-soft); border: 1px solid var(--border-2); color: var(--accent); font-size: 18px;
        }
        .ad-captcha { display: flex; align-items: center; gap: 8px; }
        .ad-captcha label { color: var(--muted); font-weight: 800; margin: 0; }
        .inputcaptcha {
            width: 54px; height: 42px; text-align: center; font-weight: 800; font-size: 16px;
            border-radius: 10px; border: 1px solid var(--border-2); background: rgba(255,255,255,.05); color: var(--text);
        }
        .inputcaptcha[readonly] { color: var(--accent); background: rgba(255,145,66,.08); }
        #cap_result:focus { outline: 0; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(255,145,66,.18); }
        .ad-actions { margin-left: auto; display: flex; gap: 10px; align-items: center; }

        .btn { border: 0; border-radius: 12px; padding: 11px 22px; font-weight: 700; font-size: 15px; cursor: pointer; transition: .18s; }
        #confirm { color: #fff; background: rgba(255,255,255,.08); border: 1px solid var(--border-2); }
        #confirm[disabled] { opacity: .55; cursor: not-allowed; }
        #confirm.btn-success { background: var(--grad); border: none; box-shadow: 0 14px 30px -14px rgba(124,58,237,.9); opacity: 1; cursor: pointer; }
        #confirm.btn-success:hover { filter: brightness(1.08); transform: translateY(-1px); }
        #report { background: transparent; color: var(--muted); border: 1px solid var(--border); }
        #report:hover { color: var(--red); border-color: rgba(244,114,182,.4); }

        /* ---------- Report modal (dark) ---------- */
        .modal-content { background: linear-gradient(180deg, var(--surface), var(--surface-2)); border: 1px solid var(--border); border-radius: 18px; color: var(--text); }
        .modal-header, .modal-footer { border-color: var(--border); }
        .modal-title { line-height: 1; font-weight: 800; }
        .close.btn { color: var(--muted); background: transparent; font-size: 24px; line-height: 1; }
        .form-control, .form-select {
            background: rgba(255,255,255,.05) !important; border: 1px solid var(--border-2) !important; color: var(--text) !important; border-radius: 10px;
        }
        .form-control:focus, .form-select:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 3px rgba(255,145,66,.15) !important; }
        .form-select option { background: var(--surface); }
        textarea.form-control { min-height: 120px; }
        .modal .btn-primary { background: var(--grad); border: none; padding: .7rem 1rem; font-weight: 700; border-radius: 12px; }
        label { color: var(--text); }

        /* ---------- Leave message ---------- */
        .leave-msg { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 30px; color: var(--text); }
        .leave-msg__icon { font-size: 60px; margin-bottom: 10px; }
        .leave-msg p { color: var(--muted); max-width: 380px; }

        @media (max-width: 600px) {
            .ad-title { display: none; }
            .ad-actionbar__inner { gap: 10px; }
            .ad-status { order: 1; }
            .ad-actions { order: 2; width: 100%; }
            .ad-actions .btn { flex: 1; }
            .ad-captcha { order: 3; width: 100%; justify-content: center; }
            .ad-stage { padding-bottom: 190px; }
        }
    </style>
</head>

<body>
    <!-- Top bar -->
    <header class="ad-topbar">
        <div class="ad-brand"><img src="{{ siteFavicon() }}" alt="logo"> <span>@lang('Watch & Earn')</span></div>
        <div class="ad-title">{{ __($ptc->title) }}</div>
        <div class="ad-reward"><i>&#127775;</i> @lang('Reward') <b>{{ showAmount($ptc->amount) }}</b></div>
    </header>

    <!-- Progress -->
    <div id="myProgress"><div id="myBar">0%</div></div>

    <!-- Ad stage -->
    <main class="ad-stage">
        <div class="ad-card">
            <div class="ad-card__bar">
                <div class="ad-card__dots"><span></span><span></span><span></span></div>
                <span class="ad-card__label">@lang('Sponsored') &middot; {{ __($ptc->title) }}</span>
                <span class="ad-card__live"><span class="dot"></span> @lang('WATCHING')</span>
            </div>
            <div class="ad-card__body">
                @if ($ptc->ads_type == 1)
                    <iframe src="{{ $ptc->ads_body }}" class="ad-embed"></iframe>
                @elseif($ptc->ads_type == 2)
                    <div class="ad-image">
                        <img src="{{ getImage(fileManager()->ptc()->path . '/' . $ptc->ads_body) }}" alt="ad">
                    </div>
                @elseif($ptc->ads_type == 3)
                    <div class="ad-script">
                        @php echo $ptc->ads_body @endphp
                    </div>
                @else
                    <div class="ad-video">
                        <iframe src="{{ $ptc->ads_body }}" title="video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Action bar -->
    <footer class="ad-actionbar">
        <form id="confirm-form" method="post">
            @csrf
            <div class="ad-actionbar__inner">
                <div class="ad-status">
                    <span class="ad-status__icon">&#9203;</span>
                    <span id="ad-status-text">@lang('Watch the ad to unlock your reward')</span>
                </div>

                <span id="inputcaptchahidden" class="ad-captcha d-none">
                    <input id="cap_number_1" name="first_number" class="inputcaptcha" value="{{ rand(0, 9) }}" type="text" readonly>
                    <label>+</label>
                    <input id="cap_number_2" name="second_number" class="inputcaptcha" value="{{ rand(0, 9) }}" type="text" readonly>
                    <label>=</label>
                    <input type="number" name="result" class="inputcaptcha" id="cap_result" placeholder="?" required>
                    <input type="hidden" name="engagement_id" value="{{ $engagement->id }}">
                </span>

                <div class="ad-actions">
                    <button type="button" id="confirm" class="btn" disabled>@lang('Loading Ad…')</button>
                    <button type="button" id="report" class="btn">@lang('Report')</button>
                </div>
            </div>
        </form>
    </footer>

    <!-- Report modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">@lang('Report This Ad')</h5>
                    <button type="button" class="close btn" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.ptc.report.submit') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ptc_id" value="{{ $ptc->id }}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>@lang('Type')</label>
                            <select name="type" class="form-control form-select" required>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ __($type->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function($, document) {
            "use strict";

            // Captcha check
            $('#cap_result').on('input', function() {
                var val1 = document.getElementById("cap_number_1").value;
                var val2 = document.getElementById("cap_number_2").value;
                var val3 = document.getElementById("cap_result").value;
                var sum = parseInt(+val1 + +val2);
                var confirmButton = document.getElementById("confirm");
                if (sum == val3) {
                    confirmButton.removeAttribute('disabled');
                    confirmButton.setAttribute('type', 'submit');
                    confirmButton.className = "btn btn-success";
                    confirmButton.innerHTML = "{{ __('Confirm & Earn') }}";
                    document.getElementById('confirm-form').setAttribute('action', '{{ route('user.ptc.confirm', encrypt($ptc->id . '|' . auth()->user()->id)) }}');
                } else {
                    confirmButton.setAttribute('disabled', '');
                    confirmButton.className = "btn";
                    confirmButton.removeAttribute('href', '#');
                }
            });

            // Watch timer → progress bar
            function move() {
                var elem = document.getElementById("myBar");
                var width = 0;
                var id = setInterval(frame, {{ $ptc->duration * 10 }});

                function frame() {
                    if (width >= 100) {
                        clearInterval(id);
                        document.getElementById("inputcaptchahidden").classList.remove("d-none");
                        document.getElementById("ad-status-text").innerHTML = "{{ __('Solve the sum to claim your reward') }}";
                        var confirmButton = document.getElementById("confirm");
                        confirmButton.className = "btn";
                        confirmButton.innerHTML = "{{ __('Confirm & Earn') }}";
                    } else {
                        width++;
                        elem.style.width = width + '%';
                    }
                }
            }
            window.onload = move;

            // Report
            $('#report').on("click", function() {
                $('#reportModal').modal('show');
            });

            // Engagement tracking on leave
            $(window).on('beforeunload', function() {
                $.get("{{ route('user.ptc.engagement', $engagement->id) }}", {}, function() {});
            });

        })(jQuery, document);
    </script>

    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>

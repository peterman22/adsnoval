@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc          = getContent('kyc.content', true);
        $todayClicks  = $user->clicks->where('view_date', Date('Y-m-d'))->count();
        $remainClicks = max(0, $user->daily_limit - $todayClicks);
        $streak       = (int) ($user->streak_count ?? 0);
        $checkedToday = (string) ($user->last_check_in ?? '') === \Carbon\Carbon::today()->toDateString();
        $spunToday    = (string) ($user->last_spin_at ?? '') === \Carbon\Carbon::today()->toDateString();
        $streakDots   = $streak % 7 == 0 && $streak > 0 ? 7 : $streak % 7;
    @endphp

    <div class="row g-4 g-lg-3 g-xxl-4">
        <div class="notice"></div>

        @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="alert-heading mb-0 mt-0">@lang('KYC Documents Rejected')</h4>
                        <a class="mb-0" href="javascript::void(0)" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Show Reason')</a>
                    </div>
                    <hr>
                    <p class="mb-0">
                        {{ __(@$kyc->data_values->reject) }}
                        <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>,
                        <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                    </p>
                </div>
            </div>
        @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
            <div class="col-12">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                    <hr>
                    <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
                </div>
            </div>
        @elseif(auth()->user()->kv == Status::KYC_PENDING)
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                    <hr>
                    <p class="mb-0">{{ __(@$kyc->data_values->pending) }} <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
                </div>
            </div>
        @endif

        {{-- ===== Welcome banner ===== --}}
        <div class="col-12">
            <div class="neon-hero">
                <div class="neon-hero__text">
                    <span class="neon-chip"><i class="las la-hand-sparkles"></i> @lang('Welcome back')</span>
                    <h2 class="neon-hero__title">{{ __($user->firstname ?? $user->username) }}</h2>
                    <p class="neon-hero__sub mb-0">@lang('Here is your earning snapshot for today.')</p>
                </div>
                <div class="neon-hero__balance">
                    <span class="neon-hero__balance-label">@lang('Available Balance')</span>
                    <span class="neon-hero__balance-value">{{ showAmount($user->balance) }}</span>
                    <div class="neon-hero__actions">
                        <a href="{{ route('user.ptc.index') }}" class="btn cmn-btn btn--sm"><i class="las la-play"></i> @lang('Watch Ads')</a>
                        <a href="{{ route('user.withdraw') }}" class="btn btn--light btn--sm"><i class="las la-money-check"></i> @lang('Withdraw')</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Streak + spin + live ticker ===== --}}
        <div class="col-xl-8">
            <div class="widget-container h-100 neon-pad">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-2">
                    <div>
                        <span class="neon-chip"><i class="las la-fire"></i> @lang('Daily Streak')</span>
                        <h3 class="neon-section-title mt-3 mb-1">{{ $streak }} @lang('Day Streak')</h3>
                        <p class="text-muted mb-0">@lang('Check in every day to grow your bonus.')</p>
                    </div>
                    <form action="{{ route('user.rewards.checkin') }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="btn cmn-btn" {{ $checkedToday ? 'disabled' : '' }}>
                            {{ $checkedToday ? __('Claimed Today') : __('Claim Daily Bonus') }}
                        </button>
                    </form>
                </div>
                <div class="neon-streak__days">
                    @for ($i = 1; $i <= 7; $i++)
                        <div class="neon-streak__day {{ $i <= $streakDots ? 'filled' : '' }}">
                            <span class="n">{{ $i }}</span>@lang('Day')
                        </div>
                    @endfor
                </div>
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mt-3 neon-divider-top">
                    <div class="d-flex align-items-center gap-2 text-muted">
                        <i class="las la-dice-d20 fs-3" style="color:var(--neon-accent)"></i>
                        <span>{{ $spunToday ? __('You already spun today') : __('Your free daily spin is ready!') }}</span>
                    </div>
                    <a href="{{ route('user.rewards.index') }}" class="btn btn--base btn--md">
                        <i class="las la-sync"></i> @lang('Spin the Wheel')
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="widget-container neon-ticker h-100 neon-pad">
                <div class="neon-ticker__head">
                    <span class="neon-ticker__live"><span class="dot"></span> @lang('Live Payouts')</span>
                    <span class="neon-ticker__meta" id="tickerTotal"></span>
                </div>
                <ul class="neon-ticker__list" id="withdrawTicker">
                    <li class="neon-ticker__item"><span class="neon-ticker__meta">@lang('Loading recent payouts…')</span></li>
                </ul>
            </div>
        </div>

        {{-- ===== Stat tiles ===== --}}
        @php
            $tiles = [
                ['label' => __('Total Withdraw'),       'value' => showAmount($user->withdrawals->where('status', 1)->sum('amount')), 'icon' => 'fas fa-credit-card', 'nw' => 'nw--cyan'],
                ['label' => __('Referral Commissions'), 'value' => showAmount($commissionCount),                     'icon' => 'fas fa-gift',           'nw' => 'nw--pink'],
                ['label' => __('Total Watched'),        'value' => $user->clicks->count(),                            'icon' => 'fas fa-trophy',         'nw' => 'nw--amber'],
                ['label' => __("Today's Watch"),        'value' => $todayClicks,                                      'icon' => 'fas fa-eye',            'nw' => 'nw--cyan'],
                ['label' => __('Remaining Today'),      'value' => $remainClicks,                                     'icon' => 'fas fa-hourglass-half', 'nw' => 'nw--amber'],
                ['label' => __('My Active Ads'),        'value' => $activeAdCount,                                    'icon' => 'fas fa-bullhorn',       'nw' => 'nw--pink'],
            ];
        @endphp

        @foreach ($tiles as $t)
            <div class="col-sm-6 col-xl-3">
                <div class="widget-container {{ $t['nw'] }}">
                    <div class="widget-container__head">
                        <span class="dashboard-widget__title">{{ $t['label'] }}</span>
                    </div>
                    <div class="dashboard-widget">
                        <div class="dashboard-widget__icon"><i class="{{ $t['icon'] }}"></i></div>
                        <div class="dashboard-widget__content">
                            <h4 class="dashboard-widget__amount">{{ $t['value'] }}</h4>
                        </div>
                        <span class="dashboard-widget__overlay-icon"><i class="{{ $t['icon'] }}"></i></span>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Plan tile --}}
        <div class="col-sm-6 col-xl-3">
            <div class="widget-container nw--green">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">@lang('My Plan')</span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon"><i class="fas fa-crown"></i></div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount" style="font-size:18px;">
                            @if ($user->plan)
                                {{ __($user->plan->name) }}@if ($user->expire_date < now()) <small>(@lang('Expired'))</small>@endif
                            @else
                                @lang('No Plan')
                            @endif
                        </h4>
                        <a href="{{ route('plans') }}" class="neon-ticker__meta" style="color:var(--neon-accent)">@lang('Upgrade') →</a>
                    </div>
                    <span class="dashboard-widget__overlay-icon"><i class="fas fa-crown"></i></span>
                </div>
            </div>
        </div>

        {{-- Next reset countdown --}}
        <div class="col-sm-6 col-xl-3">
            <div class="widget-container nw--cyan">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">@lang('Next Reset')</span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon"><i class="fas fa-clock"></i></div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount timer" id="counter" style="font-size:18px;"></h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon"><i class="fas fa-clock"></i></span>
                </div>
            </div>
        </div>

        {{-- ===== Chart ===== --}}
        <div class="col-md-12 mb-30">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title neon-section-title">@lang('Watch & Earn Report')</h5>
                    <div id="apex-bar-chart"></div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
        <div class="modal fade" id="kycRejectionReason">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('KYC Document Rejection Reason')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ auth()->user()->kyc_rejection_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            // ---- Watch & Earn chart ----
            var options = {
                series: [{
                    name: 'Clicks',
                    data: [@foreach ($chart['click'] as $click){{ $click }},@endforeach]
                }, {
                    name: 'Earn Amount',
                    data: [@foreach ($chart['amount'] as $amount){{ $amount }},@endforeach]
                }],
                chart: { type: 'bar', height: 380, toolbar: { show: false }, foreColor: '#8b96ab' },
                colors: ['#7c3aed', '#22d3ee'],
                plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 6 } },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                grid: { borderColor: 'rgba(255,255,255,.06)' },
                xaxis: { categories: [@foreach ($chart['amount'] as $key => $amount)'{{ $key }}',@endforeach] },
                fill: { opacity: 1 },
                legend: { labels: { colors: '#8b96ab' } },
                tooltip: { theme: 'dark', y: { formatter: function(val) { return val } } }
            };
            new ApexCharts(document.querySelector("#apex-bar-chart"), options).render();

            // ---- Next reset countdown ----
            function createCountDown(elementId, sec) {
                var tms = sec;
                var x = setInterval(function() {
                    var distance = tms * 1000;
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    document.getElementById(elementId).innerHTML = hours + "h " + minutes + "m " + seconds + "s";
                    if (distance < 0) { clearInterval(x); document.getElementById(elementId).innerHTML = "{{ __('Ready') }}"; }
                    tms--;
                }, 1000);
            }
            createCountDown('counter', {{ \Carbon\Carbon::tomorrow()->diffInSeconds() }});

            // ---- Live withdrawal ticker ----
            function initials(name) { return (name || '?').substring(0, 1).toUpperCase(); }
            function loadTicker() {
                $.getJSON('{{ route('withdraw.feed') }}', function(res) {
                    if (res.status !== 'success' || !res.feed.length) return;
                    $('#tickerTotal').text('{{ __('Total paid') }}: ' + res.total);
                    var $list = $('#withdrawTicker').empty();
                    res.feed.forEach(function(f, i) {
                        var li = $('<li class="neon-ticker__item"></li>').css('animation-delay', (i * 0.05) + 's');
                        li.html(
                            '<span class="neon-ticker__who"><span class="neon-ticker__avatar">' + initials(f.user) + '</span>' +
                            '<span>' + f.user + '<span class="neon-ticker__meta d-block">' + (f.method || 'Withdrawal') + ' · ' + f.ago + '</span></span></span>' +
                            '<span class="neon-ticker__amt">' + f.amount + '</span>'
                        );
                        $list.append(li);
                    });
                });
            }
            loadTicker();
            setInterval(loadTicker, 20000);

        })(jQuery);
    </script>
@endpush

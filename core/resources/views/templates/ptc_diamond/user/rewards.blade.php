@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $segments  = $segments ?? [];
        $n         = max(1, count($segments));
        $seg       = 360 / $n;
        $streak    = (int) ($user->streak_count ?? 0);
        $wheelCols  = ['#4f2ea8', '#1f2b52', '#3a1e6e', '#173a52', '#5a2ea8', '#204a63', '#2a1f5e'];
        // Build the conic-gradient slices
        $stops = [];
        foreach ($segments as $i => $s) {
            $c = $wheelCols[$i % count($wheelCols)];
            $stops[] = "$c " . ($i * $seg) . "deg " . (($i + 1) * $seg) . "deg";
        }
        $conic = 'conic-gradient(' . implode(',', $stops) . ')';
    @endphp

    <div class="row g-4">
        <div class="col-12">
            <div class="neon-hero">
                <div class="neon-hero__text">
                    <span class="neon-chip"><i class="las la-gift"></i> @lang('Daily Rewards')</span>
                    <h2 class="neon-hero__title">@lang('Spin, Streak & Earn')</h2>
                    <p class="neon-hero__sub mb-0">@lang('Come back every day for a free spin and a growing streak bonus.')</p>
                </div>
                <div class="neon-hero__balance">
                    <span class="neon-hero__balance-label">@lang('Balance')</span>
                    <span class="neon-hero__balance-value" id="rewardBalance">{{ showAmount($user->balance) }}</span>
                </div>
            </div>
        </div>

        {{-- ===== Spin the wheel ===== --}}
        <div class="col-lg-6">
            <div class="widget-container neon-pad h-100 text-center">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="neon-section-title mb-0">@lang('Spin the Wheel')</h4>
                    <span class="neon-chip"><i class="las la-ticket-alt"></i> {{ $canSpin ? __('1 free spin') : __('Come back tomorrow') }}</span>
                </div>

                <div class="neon-wheel-wrap">
                    <div class="neon-wheel__pointer"></div>
                    <div class="neon-wheel" id="wheel" style="background: {{ $conic }};">
                        @foreach ($segments as $i => $s)
                            <div class="neon-wheel__label" style="transform: rotate({{ $i * $seg + $seg / 2 }}deg);">
                                <span style="transform: rotate(90deg);">{{ $s['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="spinBtn" class="neon-wheel__hub {{ $canSpin ? '' : 'disabled' }}" {{ $canSpin ? '' : 'disabled' }}>
                        @lang('SPIN')
                    </button>
                </div>

                <p class="text-muted mt-4 mb-1" id="spinResult">
                    {{ $canSpin ? __('Tap SPIN to try your luck!') : __('You have already spun today.') }}
                </p>
                <p class="text-muted mb-0" style="font-size:13px;">
                    🎟️ @lang('Free Ads'): <b id="freeAdCount" style="color:var(--neon-accent)">{{ (int) ($user->free_ad_credits ?? 0) }}</b>
                    <span class="d-block mt-1" style="opacity:.75;">@lang('Win 1 Free Ad every') {{ config('rewards.spin.free_ad_every') }} @lang('spins')</span>
                </p>
            </div>
        </div>

        {{-- ===== Daily streak ===== --}}
        <div class="col-lg-6">
            <div class="widget-container neon-pad h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="neon-section-title mb-0">@lang('Daily Streak')</h4>
                    <span class="neon-chip"><i class="las la-fire"></i> {{ $streak }} @lang('days')</span>
                </div>

                <div class="neon-streak__days">
                    @php $dots = $streak % 7 == 0 && $streak > 0 ? 7 : $streak % 7; @endphp
                    @for ($i = 1; $i <= 7; $i++)
                        <div class="neon-streak__day {{ $i <= $dots ? 'filled' : '' }}">
                            <span class="n">{{ $i }}</span>@lang('Day')
                        </div>
                    @endfor
                </div>

                <form action="{{ route('user.rewards.checkin') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn cmn-btn w-100 btn--lg" {{ $canCheckIn ? '' : 'disabled' }}>
                        @if ($canCheckIn)
                            @lang('Claim Today\'s Bonus') (+{{ showAmount($nextReward) }})
                        @else
                            @lang('Already Claimed — Back Tomorrow')
                        @endif
                    </button>
                </form>

                <hr class="my-4" style="border-color:var(--neon-border)">

                <h6 class="text-muted mb-3">@lang('Streak Milestones')</h6>
                <ul class="list-unstyled m-0">
                    @foreach ($streakTiers as $day => $amount)
                        <li class="d-flex justify-content-between align-items-center py-2 neon-divider-top">
                            <span><i class="las la-medal" style="color:var(--neon-amber)"></i> @lang('Day') {{ $day }}+</span>
                            <span class="neon-ticker__amt">{{ showAmount($amount) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .neon-wheel { position: relative; }
        .neon-wheel__label {
            position: absolute; inset: 0; display: flex; justify-content: center;
            padding-top: 18px; pointer-events: none;
        }
        .neon-wheel__label span {
            display: inline-block; color: #fff; font-weight: 800; font-size: 13px;
            text-shadow: 0 1px 4px rgba(0,0,0,.6); transform-origin: center;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var n = {{ $n }}, seg = 360 / n, spinning = false, spun = 0;
            var $wheel = $('#wheel'), $btn = $('#spinBtn'), $res = $('#spinResult');

            $btn.on('click', function() {
                if (spinning || $btn.is(':disabled')) return;
                spinning = true;
                $btn.addClass('disabled');
                $res.text('{{ __('Spinning…') }}');

                $.ajax({
                    url: '{{ route('user.rewards.spin') }}',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        var target = res.index * seg + seg / 2;
                        spun += 6;                       // full rotations for effect
                        var rotation = spun * 360 - target;
                        $wheel.css('transform', 'rotate(' + rotation + 'deg)');
                        setTimeout(function() {
                            var prize = res.type === 'free_ad' ? '1 Free Ad 🎟️' : res.label;
                            $res.html('🎉 {{ __('You won') }} <b style="color:var(--neon-green)">' + prize + '</b>!');
                            $('#rewardBalance').text(res.balance);
                            $('#freeAdCount').text(res.free_ad_credits);
                            if (typeof iziToast !== 'undefined') {
                                iziToast.success({ title: '{{ __('Reward') }}', message: res.message, position: 'topRight' });
                            }
                        }, 5100);
                    },
                    error: function(xhr) {
                        spinning = false;
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) || '{{ __('Something went wrong') }}';
                        $res.text(msg);
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc = getContent('kyc.content', true);
    @endphp
    <div class="notice"></div>
    <div class="mb-4">
        @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
            <div class="alert alert--danger" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="alert-heading text--danger mb-0 mt-0">@lang('KYC Documents Rejected')</h4>
                    <a href="javascript::void(0)" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Show Reason')</a>
                </div>
                <hr>
                <p class="mb-0">
                    {{ __(@$kyc->data_values->reject) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Re-submit Documents')</a>,
                    <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                </p>
                <br>

            </div>
        @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
            <div class="alert alert--info" role="alert">
                <h4 class="alert-heading">@lang('KYC Verification required')</h4>
                <hr>
                <p class="mb-0">{{ __(@$kyc->data_values->required) }} <a href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a></p>
            </div>
        @elseif(auth()->user()->kv == Status::KYC_PENDING)
            <div class="alert alert--warning" role="alert">
                <h4 class="alert-heading">@lang('KYC Verification pending')</h4>
                <hr>
                <p class="mb-0 text-dark">{{ __(@$kyc->data_values->pending) }} <a href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a></p>
            </div>
        @endif
    </div>
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="row gy-4 dashboard-widget-wrapper">
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img src="{{ asset($activeTemplateTrue . 'images/thumbs/credit.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.deposit.history') }}" class="dashboard-widget__text"> @lang('Total Credit') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->balance) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb">
                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/withdrawal.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.withdraw.history') }}" class="dashboard-widget__text"> @lang('Total Withdraw') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ showAmount($user->withdrawals->where('status', 1)->sum('amount')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img src="{{ asset($activeTemplateTrue . 'images/thumbs/plan.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text"> @lang('My Plan') </span>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    @if ($user->plan)
                                        {{ __($user->plan->name) }} @if ($user->expire_date < now())
                                            (@lang('Expired'))
                                        @endif
                                    @else
                                        @lang('No Plan')
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb">
                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/click2.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.ptc.clicks') }}" class="dashboard-widget__text"> @lang('Total Clicks') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ $user->clicks->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb">
                                <img src="{{ asset($activeTemplateTrue . 'images/thumbs/today-click.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.ptc.clicks') }}?date={{ date('Y-m-d') }}" class="dashboard-widget__text"> @lang("Today's Clicks") </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ $user->clicks->where('view_date', date('Y-m-d'))->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img src="{{ asset($activeTemplateTrue . 'images/thumbs/reminder-click.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.ptc.clicks') }}" class="dashboard-widget__text"> @lang('Remain clicks for today') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ $user->daily_limit - $user->clicks->where('view_date', date('Y-m-d'))->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img src="{{ asset($activeTemplateTrue . 'images/thumbs/reminder-click.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <span class="dashboard-widget__text"> @lang('Next Reminder') </span>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    <div class="dashboard-widget__content">
                                        <h4 class="dashboard-widget__amount timer" id="counter"></h4>
                                    </div>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img
                                    src="{{ asset($activeTemplateTrue . 'images/thumbs/referral-commission.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.commissions') }}" class="dashboard-widget__text"> @lang('Referral Commissions') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ __($commissionCount) }} {{ __(gs('cur_text')) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-sm-6">
                    <div class="dashboard-widget d-flex justify-content-between flex-wrap gap-3">
                        <div class="dashboard-widget__left flex-between">
                            <div class="dashboard-widget__left-thumb"><img src="{{ asset($activeTemplateTrue . 'images/thumbs/adtive-ads.png') }}">
                            </div>
                        </div>
                        <div class="dashboard-widget__content">
                            <a href="{{ route('user.ptc.ads') }}?status=1" class="dashboard-widget__text"> @lang('My Active ADS') </a>
                            <div class="dashboard-widget__number d-flex align-items-center justify-content-between flex-wrap">
                                <span class="dashboard-widget__number-amount">
                                    {{ __($activeAdCount) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Click & Earn Report')</h5>
                <div id="apex-bar-chart"></div>
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
            // apex-bar-chart js
            var options = {
                series: [{
                    name: 'Clicks',
                    data: [
                        @foreach ($chart['click'] as $key => $click)
                            {{ $click }},
                        @endforeach
                    ]
                }, {
                    name: 'Earn Amount',
                    data: [
                        @foreach ($chart['amount'] as $key => $amount)
                            {{ $amount }},
                        @endforeach
                    ]
                }],
                chart: {
                    type: 'bar',
                    height: 580,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        @foreach ($chart['amount'] as $key => $amount)
                            '{{ $key }}',
                        @endforeach
                    ],
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
            chart.render();

            function createCountDown(elementId, sec) {
                var tms = sec;
                var x = setInterval(function() {
                    var distance = tms * 1000;
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes + "m " + seconds + "s ";
                    if (distance < 0) {
                        clearInterval(x);
                        document.getElementById(elementId).innerHTML = "{{ __('COMPLETE') }}";
                    }
                    tms--;
                }, 1000);
            }
            createCountDown('counter', {{ \Carbon\Carbon::tomorrow()->diffInSeconds() }});


        })(jQuery);
    </script>
@endpush

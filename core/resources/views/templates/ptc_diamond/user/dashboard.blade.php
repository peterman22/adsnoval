@extends($activeTemplate . 'layouts.master')
@section('content')
    @php
        $kyc = getContent('kyc.content', true);
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

       <!--- <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Total Deposit')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ showAmount($user->deposits->sum('amount')) }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </span>
                </div>
            </div>
        </div>--->
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Total Withdraw')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ showAmount($user->withdrawals->where('status', 1)->sum('amount')) }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-credit-card"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        <p>@lang('My Plan')
                                    <a href="{{ route('plans') }}" class="btn cmn-btn">
                                        
                                    </a></p>
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            @if ($user->plan)
                                {{ __($user->plan->name) }} @if ($user->expire_date < now())
                                    (@lang('Expired'))
                                @endif
                            @else
                                @lang('No Plan')
                            @endif
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-list"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Total watch')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ $user->clicks->count() }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-trophy"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang("Today's Watch")
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ $user->clicks->where('view_date', Date('Y-m-d'))->count() }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-link"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Remain Watch for today')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ $user->daily_limit - $user->clicks->where('view_date', Date('Y-m-d'))->count() }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-link"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Next Reminder')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount timer" id="counter">
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('Referral Commissions')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ __($commissionCount) }} {{ __(gs('cur_text')) }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="widget-container">
                <div class="widget-container__head">
                    <span class="dashboard-widget__title">
                        @lang('My Active ADS')
                    </span>
                </div>
                <div class="dashboard-widget">
                    <div class="dashboard-widget__icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="dashboard-widget__content">
                        <h4 class="dashboard-widget__amount">
                            {{ __($activeAdCount) }}
                        </h4>
                    </div>
                    <span class="dashboard-widget__overlay-icon">
                        <i class="fas fa-clock"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-30">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">@lang('Watch & Earn Report')</h5>
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
    
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/680fc290d22d79190b3eba36/1ipup019u';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
@endpush

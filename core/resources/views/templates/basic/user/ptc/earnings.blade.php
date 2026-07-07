@extends($activeTemplate . 'layouts.master')
@section('content')
    <section class="cmn-section">
        <div class="container">
            @if (!blank($viewads))
                <div class="row">
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="card border--widget">
                                    <div class="card-body">
                                        <h5 class="card-title">@lang('Click & Earn Report')</h5>
                                        <div id="apex-bar-chart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="filter-wrapper">
                                    <div class="filter-date">
                                        <form method="GET" class="d-flex flex-wrap gap-2 mb-4">
                                            <x-search-date-field />
                                        </form>
                                    </div>
                                </div>
                                <div class="click-wrapper">
                                    @forelse($viewads as $view)
                                        <div class="click-widget mb-2">
                                            <ul class="click-widget__value">


                                                <li class="click-widget__value-item">
                                                    <span class="fs--14px mb-0"><i class="las la-file-invoice-dollar"></i>
                                                        @lang('Total Earn')</span>
                                                    <strong class="f-w-600 fs--14px">{{ showAmount($view->total_earned) }}</strong>
                                                </li>
                                                <li class="click-widget__value-item">
                                                    <span class="fs--14px mb-0"><i class="las la-mouse"></i> @lang('Total
                                                                                                                                                    Click')</span>
                                                    <strong class="f-w-600 fs--14px">{{ $view->total_clicks }}</strong>
                                                </li>
                                                <li class="click-widget__value-item">
                                                    <span class="fs--14px mb-0"><i class="las la-calendar-alt"></i>
                                                        @lang('Date')</span>
                                                    <strong class="f-w-600 fs--14px">{{ showDateTime($view->date, 'd M, Y') }}
                                                    </strong>
                                                </li>

                                            </ul>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                        {{ paginateLinks($viewads) }}
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body p-0">
                        @include($activeTemplate . 'partials.empty', ['message' => 'PTC Click not found'])
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection





@push('style')
    <style>
        .click-widget {
            padding: 10px 20px;
            border: 1px solid #ebebeb;
            border-radius: 8px;
            background-color: #fff;
        }

        .click-widget__header {
            display: flex;
            gap: 15px;
            margin-bottom: 8px;
        }

        .click-widget__icon {
            height: 50px;
            width: 50px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .click-widget__icon svg {
            height: 35px;
            width: 35px;
            cursor: pointer;
            fill: #0099ff;
        }

        .click-widget__bottom span {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #777777;
        }

        .click-widget__value {
            width: 100%;
        }

        .click-widget__value-item {
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .click-widget__value-item:not(:last-child) {
            margin-bottom: 3px;
        }

        .bg--primary-light {
            background-color: #0099ff1a;
        }

        .click-wrapper {
            height: 400px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .click-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .click-wrapper::-webkit-scrollbar-track {
            background-color: #f3f3f3;
            border-radius: 8px;
        }

        .click-wrapper::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 10px;
        }


        .click-widget__value-item span,
        strong {
            color: #363636;
        }

        .click-widget__value-item i {
            font-size: 1.125rem;
            color: #0099ff;
            margin-right: 5px;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
@endpush


@push('script')
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
                    height: 455,
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
                    document.getElementById(elementId).innerHTML = days + "d: " + hours + "h " + minutes +
                        "m " + seconds + "s ";
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

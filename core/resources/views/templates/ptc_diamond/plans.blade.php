@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends($activeTemplate . 'layouts.frontend')
@section('content')
<a href="{{ url()->previous() ?? route('user.home') }}" class="btn btn--base">
    ← Back
</a>

    <div class="section--sm pricing-section">
        <div class="container-xl">
            <div class="row g-3 justify-content-center">
                @foreach ($plans as $plan)
                    <div class="col-sm-6 col-lg-3">
                        <div class="pricing {{ $plan->highlight == 1 ? 'pricing--popular' : '' }}">
                            @if ($plan->highlight == 1)
                                <span class="pricing__tag">@lang('Popular')</span>
                            @endif
                            <div class="pricing__head">
                                <h4 class="pricing__title">{{ __($plan->name) }}</h4>
                                <span class="pricing__sub-title">
                                    {{ __($plan->tagline) }}
                                </span>
                            </div>
                            <div class="pricing__plan">
                                <div class="pricing__plan-container">
                                    <div class="pricing__price">
                                        <span class="pricing__currency">
                                            <i class="las la-dollar-sign"></i>
                                        </span>
                                        <h1 class="pricing__amount">
                                            {{ __(showAmount($plan->price, currencyFormat: false)) }}
                                        </h1>
                                    </div>
                                    <span class="pricing__text">{{ __(gs('cur_text')) }}</span>
                                </div>


                                @if (@auth()->user()->runningPlan && @auth()->user()->plan_id == $plan->id)
                                    <button class="pricing__btn disabled">@lang('Current Package')</button>
                                @else
                                    <a class="w-100 btn btn--base"
                                        href="{{ route('user.buyPlan', @$plan->id) }}">@lang('Subscribe Now')</a>
                                @endif

                            </div>
                            <div class="pricing__body">
                                <ul class="list pricing__list">
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Daily Limit') : {{ $plan->daily_limit }} @lang('Ads')
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Referral Bonus') : @lang('Upto') {{ $plan->ref_level }} @lang('Level')
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Plan Price') : {{ showAmount($plan->price) }}
                                    </li>
                                    <li class="pricing__item pricing__item-success">
                                        @lang('Validity') : {{ $plan->validity }} @lang('Days')
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>



    </div>

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
@push('style')
    <style>
        .package-disabled {
            opacity: 0.5;
        }
    </style>
@endpush

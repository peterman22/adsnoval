@php
    $planCaption = getContent('plan.content', true);
    $gatewayCurrency = App\Models\GatewayCurrency::whereHas('method', function ($gate) {
        $gate->where('status', 1);
    })
        ->with('method')
        ->orderby('name')
        ->get();
    $plans = App\Models\Plan::where('status', 1)->get();
@endphp
<div class="section--sm pricing-section">
    <div class="section__head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="text-center">
                        <span class="section__subtitle">
                            {{ __(@$planCaption->data_values->subheading) }}
                        </span>
                        <h2 class="section__title m-0">
                            {{ __(@$planCaption->data_values->heading) }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                    <h1 class="pricing__amount">
                                        {{ __(getAmount($plan->price)) }}
                                    </h1>
                                </div>
                                <span class="pricing__text">{{ __(gs('cur_text')) }}</span>
                            </div>



                            @if (@auth()->user()->runningPlan && @auth()->user()->plan_id == $plan->id)
                                <button class="pricing__btn disabled">@lang('Current Package')</button>
                            @else
                                <a class="w-100 btn btn--base" href="{{ route('user.buyPlan', @$plan->id) }}">@lang('Subscribe Now')</a>
                            @endif

                        </div>
                        <div class="pricing__body">
                            <ul class="list pricing__list">
                                <li class="pricing__item pricing__item-success">
                                    @lang('Daily Limit') : {{ $plan->daily_limit }} @lang('PTC')
                                </li>
                                <li class="pricing__item pricing__item-success">
                                    @lang('Referral Bonus') : @lang('Upto') {{ $plan->ref_level }} @lang('Level')
                                </li>
                                <li class="pricing__item pricing__item-success">
                                    @lang('Plan Price') : {{ showAmount($plan->price, currencyFormat: false) }}
                                    {{ __(gs('cur_text')) }}
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

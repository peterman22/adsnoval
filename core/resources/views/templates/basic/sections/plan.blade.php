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
<div class="ptb-150 price section--bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($planCaption->data_values->heading) }}</h2>
                    <p>{{ __($planCaption->data_values->subheading) }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row justify-content-center">
                    @foreach ($plans as $plan)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="single-price">
                                @if ($plan->highlight)
                                    <div class="popular-badge">
                                        <span class="badge">@lang('Popular')</span>
                                    </div>
                                @endif
                                <div class="part-top">
                                    <h3>{{ __($plan->name) }}</h3>
                                    <p>@lang('Clear pricing tiers with detailed descriptions for easy comparison').</p>
                                </div>
                                <h4 class="single-price-title">{{ __(showAmount($plan->price)) }}<br></h4>
                                <div class="part-bottom">
                                    <ul>
                                        <li><i class="las la-check"></i> @lang('Daily Limit') : {{ $plan->daily_limit }}
                                            @lang('PTC')</li>
                                        <li><i class="las la-check"></i> @lang('Referral Bonus') : @lang('Upto')
                                            {{ $plan->ref_level }}
                                            @lang('Level')</li>
                                        <li><i class="las la-check"></i> @lang('Plan Price') :
                                            {{ showAmount($plan->price) }}</li>
                                        <li><i class="las la-check"></i> @lang('Validity') : {{ $plan->validity }}
                                            @lang('Days')</li>
                                    </ul>

                                    <div class="mt-4">
                                        @if (@auth()->user()->runningPlan && @auth()->user()->plan_id == $plan->id)
                                            <button class="package-disabled">@lang('Current Package')</button>
                                        @else
                                            <a class=" btn btn--base w-100" href="{{ route('user.buyPlan', @$plan->id) }}"
                                                data-plan="{{ $plan }}">@lang('Subscribe Now')</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="cmn-section price">
        <div class="container">
            <div class="row justify-content-center">
                @if (!blank($plans))
                    @foreach ($plans as $plan)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="single-price">
                                @if ($plan->highlight)
                                    <div class="popular-badge">
                                        <span class="badge badge--primary">@lang('Popular')</span>
                                    </div>
                                @endif
                                <div class="part-top">
                                    <h3>{{ __($plan->name) }}</h3>
                                    <h4 class="single-price-title">{{ showAmount($plan->price) }} <br></h4>
                                </div>
                                <div class="part-bottom">
                                    <ul>
                                        <li>@lang('Plan Details')</li>
                                        <li>@lang('Daily Limit') : {{ $plan->daily_limit }} @lang('PTC')</li>
                                        <li>@lang('Referral Bonus') : @lang('Upto') {{ $plan->ref_level }} @lang('Level')
                                        </li>
                                        <li>@lang('Plan Price') : {{ showAmount($plan->price) }}
                                        </li>
                                        <li>@lang('Validity') : {{ $plan->validity }} @lang('Days')</li>
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
                @else
                    <div class="card">
                        <div class="card-body p-0">
                            @include($activeTemplate . 'partials.empty', ['message' => 'Plan not found'])
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>


    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif


@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $(".overview-area").addClass("section--bg");
        })(jQuery);
    </script>
@endpush

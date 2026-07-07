@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $banners = getContent('banner.element');
    @endphp

    <section class="hero">
        <div class="hero__slider">
            @foreach ($banners as $banner)
                <div class="single__slide bg_img" data-background="{{ asset('assets/images/frontend/banner/' . $banner->data_values->image) }}">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="hero__content text-center">
                                    <h2 class="hero__title" data-animation="fadeInUp" data-delay=".3s">{{ __($banner->data_values->heading) }}</h2>
                                    <p data-animation="fadeInUp" data-delay=".5s">{{ __($banner->data_values->subheading) }}</p>
                                    <div class="btn-group mt-40" data-animation="fadeInUp" data-delay=".7s">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection

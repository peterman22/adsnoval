@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $banContent = getContent('ban_page.content', true);
    @endphp
    <section class="pt-120 pb-120">
    <div class="section ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-12 text-center">
                    <div class="ban-section">
                        <h4 class="text-center text-danger">
                            {{ __(@$banContent->data_values->heading) }}
                        </h4>

                        <img src="{{ frontendImage('ban_page' , @$banContent->data_values->image, '360x370') }}"
                            alt="@lang('Ban Image')">
                        <div class="mt-3">
                            <p class="fw-bold mb-1">@lang('Reason'):</p>
                            <p>{{ $user->ban_reason }}</p>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn--base">
                            <i class="las la-undo"></i>
                            @lang('Go Back')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection

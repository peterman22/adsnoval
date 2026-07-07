@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $banContent = getContent('ban_page.content', true);
    @endphp
    <div class="section ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <div class="ban-section">
                        <img src="{{ frontendImage('ban_page', @$banContent->data_values->image, '360x370') }}" alt="@lang('Ban Image')">
                        <div class="mt-3">
                            <h4 class="text-center text-danger">
                                {{ __(@$banContent->data_values->heading) }}
                            </h4>
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
@endsection

@push('style')
    <style>
        header,footer,.header-top,.section--sm{
            display: none;
        }
    </style>
@endpush
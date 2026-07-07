@extends($activeTemplate . 'layouts.app')
@section('panel')
    <div class="page-wrapper">
        @include($activeTemplate . 'partials.user_header')
        @include($activeTemplate . 'partials.breadcrumb')
        @yield('content')

    </div>

    @include($activeTemplate . 'partials.footer')


    @php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    @endphp
    @if ($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie'))
        <!-- cookies dark version start -->
        <div class="cookies-card text-center hide">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="mt-4 cookies-card__content">{{ $cookie->data_values->short_desc }} <a href="{{ route('cookie.policy') }}"
                    target="_blank">@lang('learn more')</a></p>
            <div class="cookies-card__btn mt-4">
                <a href="javascript:void(0)" class="btn cmn-btn w-100 policy">@lang('Allow')</a>
            </div>
        </div>
        <!-- cookies dark version end -->
    @endif
@endsection

@push('style')
    <style>
        body {
            background-color: #f9fbfc;
        }

        .card {
            box-shadow: none;
            border: 1px solid #ebebeb;
        }
    </style>
@endpush


@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @if (gs('registration'))
        @php
            $content = getContent('register.content', true);
        @endphp
         <div class="login-wrapper-fullscreen">
        <div class="section login-section w-100">
            <div class="container">
                <div class="row  justify-content-between align-items-center">
                    <!-- Banner Image - Desktop Only -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="{{ frontendImage('register', $content->data_values->image, '1382x1445') }}" alt="images" class="img-fluid" />
                    </div>
                    <div class="col-lg-6 col-xxl-5">
                        <div class="login-form @if (!gs('registration')) form-disabled @endif">
                            <div class="mb-3">
                                <h3 class="login-form__title">{{ __($content->data_values->heading) }}</h3>
                                <p>
                                    @lang('Already have an account?') <a href="{{ route('user.login') }}" class="t-link t-link--base text--base">@lang('Login')</a>
                                </p>
                            </div>
                            <form action="{{ route('user.register') }}" class="row verify-gcaptcha" method="post">
                                @csrf
                                @if (session()->get('reference') != null)
                                    <div class="form-group col-12">
                                        <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                        <input type="text" name="referBy" id="referenceBy" class="form-control form--control"
                                            value="{{ session()->get('reference') }}" readonly>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label class="form-label">@lang('First Name')</label>
                                    <input type="text" name="firstname" placeholder="@lang('First Name')" class="form-control form--control "
                                        value="{{ old('firstname') }}" required>

                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label">@lang('Last Name')</label>
                                    <input type="text" name="lastname" placeholder="@lang('Last Name')" class="form-control form--control "
                                        value="{{ old('lastname') }}" required>

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="email" class="form-label">@lang('Email')</label>
                                    <input type="email" name="email" id="email" placeholder="@lang('Email')"
                                        class="form-control form--control checkUser" value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group col-md-6 form-group mb-0">
                                    <label class="form-label" for="password">@lang('Password')</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                        placeholder="@lang('Password')" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label" for="password_confirmation">@lang('Confirm Password')</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form--control"
                                        placeholder="@lang('Confirm Password')" required>
                                </div>
                                <x-captcha class />
                                @if (gs('agree'))
                                    @php
                                        $policyPages = getContent('policy_pages.element', false, orderById: true);
                                    @endphp
                                    <div class="form-group col-12">
                                        <div class="form-check form--check d-block">
                                            <input type="checkbox" id="agree" @checked(old('agree')) name="agree"
                                                class="form-check-input custom--check" required>
                                            <label class="form-check-label form-label" for="agree">@lang('I agree with ') </label> <span>
                                                @foreach ($policyPages as $policy)
                                                    <a class="t-link t-link--base text--base" href="{{ route('policy.pages', @$policy->slug) }}"
                                                        target="_blank">{{ __($policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12 form-group">
                                    <button type="submit" class="btn btn--lg btn--base w-100 rounded">@lang('Register Now')</button>
                                </div>
                                <div class="col-12">
                                    @include($activeTemplate . 'partials.social_login')
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade custom--modal" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                        <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <a href="{{ route('user.login') }}" class="btn btn--base">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include($activeTemplate . 'partials.registration_disabled')
    @endif
@endsection

@push('style')
    <style>
    
        .login-wrapper-fullscreen {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding: 0;
        margin: 0;
    }

    .login-form {
        padding: 40px 30px;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    }

    .login-form__title {
        margin-bottom: 20px;
        font-weight: 700;
        font-size: 1.8rem;
        text-align: center;
        position: relative;
        color: #222;
    }
    
    .login-section {
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}

        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .btn {
            border: 1px solid transparent !important;
        }

        .content-area {
            z-index: -1;
            height: 100%;
        }

        .btn-outline-linkedin {
            border-color: #0077B5 !important;
            background-color: #0077B5;
            color: #ffff;
        }

        .btn-outline-linkedin:hover {
            border-color: #0077B5 !important;
            color: #fff !important;
            background-color: #0077B5;
        }

        .btn-outline-facebook {
            border-color: #395498 !important;
            background-color: #395498;
            color: #ffff;
        }

        .btn-outline-facebook:hover {
            border-color: #395498 !important;
            color: #fff !important;
            background-color: #395498;
        }

        .btn-outline-google {
            border-color: #D64937 !important;
            background-color: #D64937;
            color: #ffff;
        }

        .btn-outline-google:hover {
            border-color: #D64937;
            color: #fff !important;
            background-color: #D64937;
        }

        .row>* {
            padding-right: calc(var(--bs-gutter-x) * .0);
        }

        .socials-buttons .btn {
            width: calc(33% - 10px);
        }

        @media (max-width: 424px) {
            .socials-buttons .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        .social-login-btn {
            border: 1px solid #cbc4c4;
        }
    </style>
@endpush

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.checkUser').on('focusout', function(e) {
                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                var data = {
                    email: value,
                    _token: token
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $('#existModalCenter').modal('show');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush

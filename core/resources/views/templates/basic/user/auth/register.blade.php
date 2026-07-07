@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @if (gs('registration'))
        @php
            $registerCaption = getContent('register.content', true);
        @endphp

        <section class="pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="login-area  @if (!gs('registration')) form-disabled @endif">

                            <div class="text-center mb-3">
                                <h2 class="title">{{ __($registerCaption->data_values->heading) }}</h2>
                                <p>@lang('Haven an account? ') <a href="{{ route('user.login') }}">@lang('Login Now')</a></p>
                            </div>
                            <form class="action-form verify-gcaptcha loginForm  disableSubmission" action="{{ route('user.register') }}" method="post">
                                @csrf
                                <div class="row">
                                    @if (session()->get('reference') != null)
                                        <div class="form-group col-sm-12">
                                            <label for="referenceBy" class="form-label">@lang('Reference by')</label>
                                            <input type="text" name="referBy" id="referenceBy" class="form-control"
                                                value="{{ session()->get('reference') }}" readonly>
                                        </div>
                                    @endif

                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang('First Name')</label>
                                        <input type="text" class="form-control form--control" name="firstname" value="{{ old('firstname') }}" required>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label class="form-label">@lang('Last Name')</label>
                                        <input type="text" class="form-control form--control" name="lastname" value="{{ old('lastname') }}" required>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">@lang('E-Mail Address')</label>
                                            <input type="email" class="form-control form--control checkUser" name="email" value="{{ old('email') }}"
                                                required>
                                        </div>
                                    </div>


                                    <div class="form-group hover-input-popup col-sm-6">
                                        <label>@lang('Password')</label>
                                        <input type="password" class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                            name="password" required>
                                    </div><!-- form-group end -->
                                    <div class="form-group mb-3 col-sm-6">
                                        <label>@lang('Confirm Password')</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div><!-- form-group end -->

                                    <x-captcha />

                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', false, orderById: true);
                                        @endphp
                                        <div class="form-group col-sm-6">
                                            <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                                            <label for="agree">@lang('I agree with') </label> <span>
                                                @foreach ($policyPages as $policy)
                                                    <a href="{{ route('policy.pages', $policy->slug) }}"
                                                        target="_blank">{{ __($policy->data_values->title) }}</a>
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </div><!-- form-group end -->
                                    @endif
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn--base w-100">@lang('Register Now')</button>
                                    </div>
                                </div>
                            </form>
                            @include($activeTemplate . 'partials.social_login', [($register = true)])
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
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
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
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
        "use strict";
        (function($) {

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

@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @if (gs('registration'))
        @php
            $registerContent = getContent('register.content', true);
        @endphp
        <section class="account py-120">
            <div class="container">
                <div class="row justify-content-center gy-4">
                    <div class="col-lg-6">
                        <div class="account-form  @if (!gs('registration')) form-disabled @endif">

                            @if (!gs('registration'))
                                <span class="form-disabled-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="80"
                                        height="80" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                        class="">
                                        <g>
                                            <path
                                                d="M255.999 0c-79.044 0-143.352 64.308-143.352 143.353v70.193c0 4.78 3.879 8.656 8.659 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193c0-42.998 34.981-77.98 77.979-77.98s77.979 34.982 77.979 77.98v70.193c0 4.78 3.88 8.656 8.661 8.656h48.057a8.657 8.657 0 0 0 8.656-8.656v-70.193C399.352 64.308 335.044 0 255.999 0zM382.04 204.89h-30.748v-61.537c0-52.544-42.748-95.292-95.291-95.292s-95.291 42.748-95.291 95.292v61.537h-30.748v-61.537c0-69.499 56.54-126.04 126.038-126.04 69.499 0 126.04 56.541 126.04 126.04v61.537z"
                                                fill="#ff7149" opacity="1" data-original="#ff7149" class=""></path>
                                            <path
                                                d="M410.63 204.89H101.371c-20.505 0-37.188 16.683-37.188 37.188v232.734c0 20.505 16.683 37.188 37.188 37.188H410.63c20.505 0 37.187-16.683 37.187-37.189V242.078c0-20.505-16.682-37.188-37.187-37.188zm19.875 269.921c0 10.96-8.916 19.876-19.875 19.876H101.371c-10.96 0-19.876-8.916-19.876-19.876V242.078c0-10.96 8.916-19.876 19.876-19.876H410.63c10.959 0 19.875 8.916 19.875 19.876v232.733z"
                                                fill="#ff7149" opacity="1" data-original="#ff7149" class=""></path>
                                            <path
                                                d="M285.11 369.781c10.113-8.521 15.998-20.978 15.998-34.365 0-24.873-20.236-45.109-45.109-45.109-24.874 0-45.11 20.236-45.11 45.109 0 13.387 5.885 25.844 16 34.367l-9.731 46.362a8.66 8.66 0 0 0 8.472 10.436h60.738a8.654 8.654 0 0 0 8.47-10.434l-9.728-46.366zm-14.259-10.961a8.658 8.658 0 0 0-3.824 9.081l8.68 41.366h-39.415l8.682-41.363a8.655 8.655 0 0 0-3.824-9.081c-8.108-5.16-12.948-13.911-12.948-23.406 0-15.327 12.469-27.796 27.797-27.796 15.327 0 27.796 12.469 27.796 27.796.002 9.497-4.838 18.246-12.944 23.403z"
                                                fill="#ff7149" opacity="1" data-original="#ff7149" class=""></path>
                                        </g>
                                    </svg>
                                </span>
                            @endif
                            <div class="account-form__content mb-4 text-center">
                                <h3 class="account-form__title mb-2"> {{ __($registerContent->data_values->heading) }} </h3>
                                <p class="account-form__desc"> {{ __($registerContent->data_values->subheading) }} </p>
                            </div>
                            <form class="verify-gcaptcha" action="{{ route('user.register') }}" method="POST">
                                @csrf
                                <div class="row">
                                    @if (session()->get('reference') != null)
                                        <div class="col-sm-12 form-group">
                                            <div class="form--group">
                                                <label class="form--label" for="referenceBy">@lang('Reference by')</label>
                                                <input class="form--control" id="referenceBy" name="referBy" type="text"
                                                    value="{{ session()->get('reference') }}" readonly>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-sm-12  col-md-6 form-group">
                                        <div class="form--group">
                                            <label class="form--label">@lang('First Name')</label>
                                            <input class="form--control" name="firstname" type="text" value="{{ old('firstname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <div class="form--group">
                                            <label class="form--label">@lang('Last Name')</label>
                                            <input class="form--control" name="lastname" type="text" value="{{ old('lastname') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="form--group">
                                            <label class="form--label">@lang('E-Mail Address')</label>
                                            <input class="form--control checkUser" name="email" type="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label class="form--label">@lang('Password')</label>
                                        <div class="position-relative">
                                            <input class="form-control form--control @if (gs('secure_password')) secure-password @endif"
                                                id="password" name="password" type="password" required>
                                            <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 form-group">
                                        <label class="form--label">@lang('Confirm Password')</label>
                                        <div class="position-relative">
                                            <input class="form-control form--control" id="confirm-password" name="password_confirmation" type="password"
                                                required>
                                            <div class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#confirm-password"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <x-captcha />
                                    </div>
                                    @if (gs('agree'))
                                        @php
                                            $policyPages = getContent('policy_pages.element', false, orderById: true);
                                        @endphp

                                        <div class="col-sm-12">
                                            <div class="form--check form-group">
                                                <input class="form-check-input" type="checkbox" id="agree" @checked(old('agree')) name="agree"
                                                    required>
                                                <div class="form-check-label">
                                                    <label for="agree">@lang('I agree with')</label> <span>
                                                        @foreach ($policyPages as $policy)
                                                            <a href="{{ route('policy.pages', @$policy->slug) }}" class="text--base"
                                                                target="_blank">{{ __($policy->data_values->title) }}</a>
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 form-group">
                                        <button class="btn btn--base w-100" type="submit"> @lang('Sign Up') </button>
                                    </div>
                                    @include($activeTemplate . 'partials.social_login')
                                    <div class="col-sm-12">
                                        <div class="have-account text-center">
                                            <p class="have-account__text">@lang('Already have an account') <a class="have-account__link underline-with-text"
                                                    href="{{ route('user.login') }}">@lang('Sign In')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade" id="existModalCenter" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                        <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                            <i class="las la-times"></i>
                        </span>
                    </div>
                    <div class="modal-body">
                        <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-dark btn--sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                        <a class="btn btn--base btn--sm" href="{{ route('user.login') }}">@lang('Login')</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include($activeTemplate . 'partials.registration_disabled')
    @endif
@endsection


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

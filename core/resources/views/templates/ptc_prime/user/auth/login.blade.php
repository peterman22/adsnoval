@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $loginContent = getContent('login.content', true);
    @endphp
    <div class="container">
        <section class="account py-120">
            <div class="container">
                <div class="row justify-content-center gy-4">
                    <div class="col-lg-6">
                        <div class="account-form">
                            <div class="account-form__content mb-4 text-center">
                                <h3 class="account-form__title mb-2"> {{ __($loginContent->data_values->heading) }} </h3>
                                <p class="account-form__desc"> {{ __($loginContent->data_values->subheading) }} </p>
                            </div>
                            <form class="verify-gcaptcha" method="POST" action="{{ route('user.login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 form-group">
                                        <label class="form--label" for="email">@lang('Username or Email')</label>
                                        <input class="form--control" name="username" type="text" value="{{ old('username') }}" required>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <label class="form--label">@lang('Password')</label>
                                        <div class="position-relative">
                                            <input class="form--control" id="password" name="password" type="password" required>
                                            <span class="password-show-hide fas fa-eye toggle-password fa-eye-slash" id="#password"></span>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <x-captcha />
                                    </div>
                                    <div class="form-group col-12">
                                        <button class="btn btn--base w-100" type="submit">@lang('Sign In')</button>
                                    </div>
                                    @include($activeTemplate . 'partials.social_login')
                                    <div class="col-sm-12 pb-2">
                                        <div class="have-account text-center">
                                            <p class="have-account__text"> <a class="have-account__link underline-with-text"
                                                    href="{{ route('user.password.request') }}">@lang('Forgot your password?')</a></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="have-account text-center">
                                            <p class="have-account__text"> @lang('Don\'t have an account') <a class="have-account__link underline-with-text"
                                                    href="{{ route('user.register') }}">@lang('Sign Up')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

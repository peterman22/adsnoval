@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends($activeTemplate . 'layouts.frontend')

@section('content')
    @php
        $content = getContent('login.content', true);
    @endphp

    <div class="login-wrapper-fullscreen">
        <div class="section login-section w-100">
            <div class="container">
                <div class="row gy-3 justify-content-between align-items-center">
                    <!-- Banner Image - Desktop Only -->
                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="{{ frontendImage('login', $content->data_values->image, '1382x1445') }}" alt="images" class="img-fluid" />
                    </div>

                    <!-- Login Form -->
                    <div class="col-lg-6 col-12">
                        <div class="login-form w-100 px-3" style="max-width: 500px; margin: auto;">
                            <div class="mb-3">
                                <h3 class="login-form__title">{{ __($content->data_values->heading) }}</h3>
                                <p>
                                    @lang("Don`t have an account?") <a href="{{ route('user.register') }}" class="t-link t-link--base text--base">@lang('Create an Account')</a>
                                </p>
                            </div>

                            <form action="{{ route('user.login') }}" class="row verify-gcaptcha" method="post">
                                @csrf
                                <div class="form-group col-12">
                                    <label class="form-label" for="username">@lang('Username or Email')</label>
                                    <input type="text" id="username" name="username" class="form-control form--control" placeholder="@lang('Username or Email')" required />
                                </div>

                                <div class="form-group col-12">
                                    <label class="form-label" for="password">@lang('Password')</label>
                                    <input type="password" id="password" name="password" class="form-control form--control" placeholder="@lang('Password')" required />
                                </div>

                                <div class="form-group col-sm-6">
                                    <div class="form-check form--check">
                                        <input class="form-check-input custom--check" type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                        <label class="form-check-label form-label" for="rememberMe">@lang('Remember Me')</label>
                                    </div>
                                </div>

                                <div class="col-sm-6 form-group">
                                    <a href="{{ route('user.password.request') }}" class="t-link d-block text-sm-end text--base t-link--base form-label lh-1">
                                        @lang('Forgot password?')
                                    </a>
                                </div>

                                <x-captcha />

                                <div class="col-12 form-group">
                                    <button type="submit" class="btn btn--lg btn--base w-100 rounded">@lang('Login Now')</button>
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
    </div>
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


    .btn {
        border: 1px solid transparent !important;
    }

    .btn-outline-linkedin {
        border-color: #0077B5 !important;
        background-color: #0077B5;
        color: #fff;
    }

    .btn-outline-facebook {
        border-color: #395498 !important;
        background-color: #395498;
        color: #fff;
    }

    .btn-outline-google {
        border-color: #D64937 !important;
        background-color: #D64937;
        color: #fff;
    }

    .btn-outline-linkedin:hover,
    .btn-outline-facebook:hover,
    .btn-outline-google:hover {
        color: #fff !important;
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
</style>
@endpush

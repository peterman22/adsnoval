@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $loginCaption = getContent('login.content', true);
    @endphp
    <section class="pt-120 pb-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-area">
                        <div class="text-center">
                            <h2 class="title">{{ __($loginCaption->data_values->heading) }}</h2>
                            <p>@lang("Haven't an account? ") <a href="{{ route('user.register') }}">@lang('Register Now')</a></p>
                        </div>
                        <form class="action-form loginForm verify-gcaptcha" action="{{ route('user.login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('Username or Email')</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="las la-user"></i></div>
                                    <input type="username" name="username" class="form-control" required>
                                </div>
                            </div><!-- form-group end -->
                            <div class="form-group mb-3">
                                <label>@lang('Password')</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="las la-key"></i></div>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div><!-- form-group end -->
                            <div class="d-flex gap-2 justify-content-between align-items-center flex-wrap form-group ">
                                <div class="form-check">
                                    <input class="form-check-input w-auto p-2" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        @lang('Remember Me')
                                    </label>
                                </div>
                                <a href="{{ route('user.password.request') }}">@lang('Forget Password')</a>
                            </div>
                            <x-captcha />
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn--base w-100">@lang('Login Now')</button>
                            </div>
                            @include($activeTemplate . 'partials.social_login')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    </style>
@endpush

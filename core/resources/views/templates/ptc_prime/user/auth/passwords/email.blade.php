@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="account py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-5">
                    <div class="account-form">
                        <div class="account-form__content mb-4 text-center">
                            <h5 class="account-form__title mb-2"> {{ __($pageTitle) }} </h5>
                        </div>
                        <div class="mb-4">
                            <p>@lang('To recover your account please provide your email or username to find your account.')</p>
                        </div>
                        <form class="verify-gcaptcha" method="POST" action="{{ route('user.password.email') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form--label">@lang('Email or Username')</label>
                                <input class="form--control" name="value" type="text" value="{{ old('value') }}" required autofocus="off">
                            </div>

                            <x-captcha />

                            <div class="form-group">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

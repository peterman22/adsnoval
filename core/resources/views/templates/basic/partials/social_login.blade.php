@php
    $text = isset($register) ? 'Register' : 'Login';
@endphp
@if (
    @gs('socialite_credentials')->linkedin->status ||
        @gs('socialite_credentials')->facebook->status == Status::ENABLE ||
        @gs('socialite_credentials')->google->status == Status::ENABLE)
    <p class="text-center sm-text mb-3">@lang('OR')</p>

    <div class="socials-buttons d-flex flex-wrap flex-row gap-10 justify-content-between">
        @if (@gs('socialite_credentials')->google->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'google') }}" class="btn btn-outline-google btn-sm text-uppercase">
                <span class="me-1"><i class="lab l la-google"></i></span>
                @lang('Google')</a>
        @endif
        @if (@gs('socialite_credentials')->facebook->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'facebook') }}" class="btn btn-outline-facebook btn-sm text-uppercase">
                <span class="me-1"><i class="lab la-facebook"></i></span>
                @lang('Facebook')</a>
        @endif
        @if (@gs('socialite_credentials')->linkedin->status == Status::ENABLE)
            <a href="{{ route('user.social.login', 'linkedin') }}" class="btn btn-outline-linkedin btn-sm text-uppercase">
                <span class="me-1"><i class="lab la-linkedin-in"></i></span>
                @lang('Linkedin')</a>
        @endif
    </div>

    @push('style')
        <style>
            .social-login-btn {
                border: 1px solid #cbc4c4;
            }
        </style>
    @endpush
@endif

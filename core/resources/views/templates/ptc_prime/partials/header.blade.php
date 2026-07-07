@php
    $languages = App\Models\Language::get();
    $defaultLanguage = App\Models\Language::where('code', config('app.locale'))->first();
    $pages = App\Models\Page::where('tempname', $activeTemplate)
        ->where('is_default', Status::NO)
        ->get();
@endphp

<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-xl navbar-light">
            <a class="navbar-brand logo" href="{{ route('home') }}"><img src="{{ asset(siteLogo()) }}" alt="logo"></a>
            <button class="navbar-toggler header-button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu align-items-xl-center ms-auto">
                    <li class="nav-item d-block d-xl-none">
                        <div class="top-button d-flex justify-content-between align-items-center flex-wrap">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected dropdown-list__item">
                                    <div class="thumb"> <img
                                            src="{{ getImage(getFilePath('language') . '/' . $defaultLanguage->image, getFileSize('language')) }}"
                                            alt="image"></div>
                                    <span class="text text-capitalize"> {{ strtoupper($defaultLanguage->code) }} </span>
                                </div>
                                <ul class="dropdown-list">
                                    @foreach ($languages as $language)
                                        <li class="dropdown-list__item langSel" data-value="{{ $language->code }}">
                                            <a class="thumb" href="#"> <img
                                                    src="{{ getImage(getFilePath('language') . '/' . $language->image), getFileSize('language') }}"
                                                    alt="image"></a>
                                            <span class="text text-capitalize"> {{ strtoupper($language->code) }} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <ul>
                                @auth
                                    <li class="header-login__item">
                                        <a class="btn btn--base" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                                    </li>
                                @else
                                    <li class="header-login__item">
                                        <a class="btn btn--base" href="{{ route('user.register') }}">@lang('Get Started')</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item {{ menuActive('home') }}">
                        <a class="nav-link" href="{{ route('home') }}" aria-current="page">@lang('Home')</a>
                    </li>
                    @foreach ($pages as $page)
                        <li class="nav-item {{ menuActive('pages', [$page->slug]) }}">
                            <a class="nav-link" href="{{ route('pages', [$page->slug]) }}" aria-current="page"> {{ __($page->name) }} </a>
                        </li>
                    @endforeach
                    <li class="nav-item {{ menuActive('plans') }}">
                        <a class="nav-link" href="{{ route('plans') }}">@lang('Plans')</a>
                    </li>
                    <li class="nav-item {{ menuActive('blog') }}">
                        <a class="nav-link" href="{{ route('blog') }}"> @lang('Blogs') </a>
                    </li>
                    <li class="nav-item {{ menuActive('contact') }}">
                        <a class="nav-link" href="{{ route('contact') }}"> @lang('Contact') </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        </li>
                    @else
                        <li class="nav-item {{ menuActive('user.login') }}">
                            <a class="nav-link" href="{{ route('user.login') }}">@lang('Login')</a>
                        </li>
                    @endauth
                </ul>
                <div class="d-none d-xl-block">
                    <ul class="header-login list primary-menu">
                        @guest
                            <li class="header-login__item">
                                <a class="btn btn--base" href="{{ route('user.register') }}">@lang('Get Started')</a>
                            </li>
                        @endguest
                        @auth
                            <li class="header-login__item">
                                <a class="btn btn--base" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                            </li>
                        @endauth
                        <li class="header-login__item">
                            <div class="custom--dropdown">
                                <div class="custom--dropdown__selected dropdown-list__item">
                                    <div class="thumb"> <img
                                            src="{{ getImage(getFilePath('language') . '/' . $defaultLanguage->image, getFileSize('language')) }}"
                                            alt="image"></div>
                                    <span class="text text-capitalize"> {{ strtoupper($defaultLanguage->code) }} </span>
                                </div>
                                <ul class="dropdown-list">
                                    @foreach ($languages as $language)
                                        <li class="dropdown-list__item langSel" data-value="{{ $language->code }}">
                                            <a class="thumb" href="#">
                                                <img src="{{ getImage(getFilePath('language') . '/' . $language->image), getFileSize('language') }}"
                                                    alt="image">
                                            </a>
                                            <span class="text text-capitalize"> {{ strtoupper($language->code) }} </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
</header>

@php
    $content = getContent('header.content', true);
    $languages = App\Models\Language::get();
    $defaultLanguage = App\Models\Language::where('code', config('app.locale'))->first();
@endphp


<header
    class="header-primary {{ request()->routeIs('user.login') || request()->routeIs('user.register') ? 'header-primary--sticky' : 'header-primary--fixed' }}">
    <div class="container">
        <div class="header-primary__content">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ siteLogo() }}" alt="site-logo" class="img-fluid logo__is" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-expanded="false">
                    <span class="menu-toggle"></span>
                </button>
            </nav>
            <div class="collapse navbar-collapse" id="navbarToggle">
                <div class="nav-container">
                    <ul class="list primary-menu  justify-content-lg-end">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="primary-menu__link">@lang('Home')</a>
                        </li>
                        @php
                            $pages = App\Models\Page::where('tempname', $activeTemplate)
                                ->where('is_default', Status::NO)
                                ->get();
                        @endphp
                        @foreach ($pages as $page)
                            @if ($page->slug != 'home' && $page->slug != 'blog' && $page->slug != 'contact')
                                <li>
                                    <a href="{{ route('pages', $page->slug) }}" class="primary-menu__link">{{ __($page->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li>
                            <a href="{{ route('plans') }}" class="primary-menu__link">@lang('Plans')</a>
                        </li>
                       <li>
                        @guest
                            <a href="{{ route('user.login') }}" class="login-btn rounded-pill">
                                <span class="login-btn__icon">
                                    <i class="las la-user"></i>
                                </span>
                                <span class="login-btn__text">@lang('Login/Signup')</span>
                            </a>
                        @else
                            <a href="{{ route('user.home') }}" class="login-btn rounded-pill">
                                <span class="login-btn__icon">
                                    <i class="las la-tachometer-alt"></i>
                                </span>
                                <span class="login-btn__text">@lang('Dashboard')</span>
                            </a>
                        @endguest
                    </li>
                        <li class="nav-item">
                            <a href="{{ route('contact') }}" class="primary-menu__link">@lang('Contact')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>


    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0 align-items-center">
                <a class="site-logo site-title" href="{{ route('home') }}"><img src="{{ siteLogo() }}"
                        alt="site-logo"><span class="logo-icon"><i class="flaticon-fire"></i></span></a>
                <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav main-menu ms-auto">
                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                        @php
                            $pages = App\Models\Page::where('tempname', $activeTemplate)
                                ->where('is_default', Status::NO)
                                ->get();
                        @endphp
                        @foreach ($pages as $page)
                            @if ($page->slug != 'home' && $page->slug != 'blog' && $page->slug != 'contact')
                                <li><a href="{{ route('pages', $page->slug) }}">{{ __($page->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                        <li><a href="{{ route('plans') }}">@lang('Plans')</a></li>
                      
                    </ul>
                    <div class="nav-right">
                        <a href="{{ route('contact') }}" class="cmn-btn style--three">@lang('Contact')</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

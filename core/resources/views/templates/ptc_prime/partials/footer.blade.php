@php
    $footerContent  = getContent('footer.content', true);
    $socialIcons    = getContent('social_icon.element', false, false, true);
    $footerElements = getContent('footer.element');
    $policyPages    = getContent('policy_pages.element', false, null, true);
@endphp


<footer class="footer-area">
    <div class="pb-60 pt-60">
        <div class="container">
            <div class="footer-item__logo">
                <a href="{{ route('home') }}"> <img src="{{ siteLogo() }}" alt=""></a>
            </div>
            <div class="row justify-content-center gy-5">
                <div class="col-xl-6 col-sm-6 col-xsm-6">
                    <div class="footer-item footer-item-left">
                        <p class="footer-item__desc"> {{ __(@$footerContent->data_values->about) }} </p>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Quick Link')</h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('plans') }}">@lang('Plans')</a></li>
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('blog') }}">@lang('Blogs')</a></li>
                            <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('contact') }}">@lang('Contact')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title">@lang('Privacy and Terms')</h5>
                        <ul class="footer-menu">
                            @foreach ($policyPages as $policy)
                                <li class="footer-menu__item"><a class="footer-menu__link" href="{{ route('policy.pages', $policy->slug) }}">
                                     {{ __($policy->data_values->title) }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-6 col-xsm-6">
                    <div class="footer-item">
                        <h5 class="footer-item__title"> @lang('Contact Info') </h5>
                        <ul class="footer-menu">
                            @foreach ($footerElements as $footerElement)
                                <li class="footer-menu__item">
                                    <div class="d-flex footer-icon">
                                        @php
                                            $type=@$footerElement->data_values->information_type;
                                             echo $footerElement->data_values->icon
                                        @endphp
                                       @if ($type=='mailto' ||$type=='tel'  )
                                         <a class="footer-menu__link" href="{{ $type }}:{{ $footerElement->data_values->information}}">
                                            {{ $footerElement->data_values->information }}
                                         </a>
                                       @else
                                          <span> {{ __($footerElement->data_values->information) }} </span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="footer-bottom-inner">
                <div class="row gy-3 align-items-center">
                    <div class="col-md-8">
                        <div class="bottom-footer-copyright">
                            <ul>
                                <li>@lang('Copyright') &copy; {{ date('Y') }}. @lang('All Rights Reserved By') <a class="t-link" href="{{ route('home') }}">{{ __(gs('site_name')) }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-social">
                            @foreach ($socialIcons as $social)
                                <a href="{{$social->data_values->url}}" target="_blank">
                                    @php echo $social->data_values->icon; @endphp
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
</footer>

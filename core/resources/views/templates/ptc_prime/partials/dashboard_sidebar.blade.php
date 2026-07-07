<div class="sidebar-menu flex-between">
    <div class="sidebar-menu__inner">
        <span class="sidebar-menu__close d-lg-none d-block"><i class="fas fa-times"></i></span>
        <div class="sidebar-logo">
            <a class="sidebar-logo__link" href="{{route('home')}}"><img src="{{siteLogo()}}" alt="site logo"></a>
        </div>
        <ul class="sidebar-menu-list">
            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link" href="{{route('user.home')}}">
                    <span class="icon"><i class="las la-tachometer-alt"></i></span>
                    <span class="text">@lang('Dashboard')</span>
                </a>
            </li>
            <li class="sidebar-menu-list__item has-dropdown {{menuActive('user.deposit*')}}">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-wallet"></i>
                   </span>
                    <span class="text"> @lang('Deposit') </span>
                </a>
                <div class="sidebar-submenu {{menuActive('user.deposit*')}}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  {{menuActive('user.deposit.index')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.deposit.index') }}">
                                <span class="text">  @lang('Deposit Now') </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{menuActive('user.deposit.history')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.deposit.history') }}">
                                <span class="text"> @lang('Deposit History') </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown {{menuActive('user.withdraw*')}}">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-money-check"></i>
                   </span>
                    <span class="text"> @lang('Withdraw') </span>
                </a>
                <div class="sidebar-submenu {{menuActive('user.withdraw*')}}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  {{menuActive('user.withdraw')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.withdraw') }}">
                                <span class="text"> @lang('Withdraw Now') </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{menuActive('user.withdraw.history')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.withdraw.history') }}">
                                <span class="text">  @lang('Withdraw History') </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown {{menuActive('user.ptc*')}}">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-mouse"></i>
                   </span>
                    <span class="text"> @lang('PTC') </span>
                </a>
                <div class="sidebar-submenu {{menuActive('user.ptc*')}}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  {{menuActive('user.ptc.index')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.ptc.index') }}">
                                <span class="text">  @lang('Ads') </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{menuActive('user.ptc.ads')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.ptc.ads') }}">
                                <span class="text">   @lang('My Ads') </span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-list__item {{menuActive('user.ptc.clicks')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.ptc.clicks') }}">
                                <span class="text"> @lang('Clicks') </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item has-dropdown {{menuActive(['user.commissions','user.referred'])}}">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-gift"></i>
                   </span>
                    <span class="text"> @lang('Referral') </span>
                </a>
                <div class="sidebar-submenu {{menuActive(['user.commissions','user.referred'])}}" >
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  {{menuActive('user.commissions')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.commissions') }}">
                                <span class="text"> @lang('Commissions') </span>
                            </a>
                        </li>

                        <li class="sidebar-submenu-list__item {{menuActive('user.referred')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('user.referred') }}">
                                <span class="text"> @lang('Referred Users') </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-menu-list__item {{menuActive('user.transactions')}}">
                <a class="sidebar-menu-list__link" href="{{route('user.transactions')}}">
                    <span class="icon">
                        <i class="las la-money-bill"></i>
                    </span>
                    <span class="text">@lang('Transactions')</span>
                </a>
            </li>
            @if(gs('balance_transfer'))
            <li class="sidebar-menu-list__item {{menuActive('user.transfer.balance')}}">
                <a class="sidebar-menu-list__link" href="{{route('user.transfer.balance')}}">
                    <span class="icon">
                        <i class="las la-credit-card"></i>
                    </span>
                    <span class="text">@lang('Balance Transfer')</span>
                </a>
            </li>
            @endif

            <li class="sidebar-menu-list__item has-dropdown {{menuActive('ticket*')}}">
                <a class="sidebar-menu-list__link" href="#">
                   <span class="icon">
                    <i class="las la-question-circle"></i>
                   </span>
                    <span class="text"> @lang('Help & Support') </span>
                </a>
                <div class="sidebar-submenu {{menuActive('ticket*')}}">
                    <ul class="sidebar-submenu-list">
                        <li class="sidebar-submenu-list__item  {{menuActive('ticket.index')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('ticket.index') }}">
                                <span class="text"> @lang('Support Ticket') </span>
                            </a>
                        </li>

                        <li class="sidebar-submenu-list__item {{menuActive('ticket.open')}}">
                            <a class="sidebar-submenu-list__link" href="{{ route('ticket.open') }}">
                                <span class="text"> @lang('New Ticket') </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-list__item">
                <a class="sidebar-menu-list__link" href="{{route('user.logout')}}">
                    <span class="icon"><i class="las la-sign-out-alt"></i></span>
                    <span class="text">@lang('Logout')</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidebar-bottom">
        <div class="sidebar-bottom__btn">
            @lang('Copyright') &copy; {{ date('Y') }}. @lang('All Rights Reserved By') <a class="t-link" href="{{ route('home') }}">{{ __(gs('site_name')) }}</a>
        </div>
    </div>
</div>

<div class="dashboard-sidebar">
    <div class="dashboard-sidebar__nav-toggle">
        <span class="dashboard-sidebar__nav-toggle-text">
            <span class="nav-toggle-balance">
                <span class="nav-toggle-balance__label">@lang('Balance')</span>
                <span class="nav-toggle-balance__value">{{ showAmount(auth()->user()->balance) }}</span>
            </span>
        </span>
        <button type="button" class="btn dashboard-sidebar__nav-toggle-btn" aria-label="@lang('Open menu')">
            <i class="las la-bars"></i>
        </button>
    </div>
    <div class="dashboard-menu">
        <div class="dashboard-menu__head">
            <span class="dashboard-menu__head-text">@lang('My Account')</span>
            <button type="button" class="btn dashboard-menu__head-close">
                <i class="las la-times"></i>
            </button>
        </div>
        <div class="dashboard-menu__body" data-simplebar="">
            <ul class="list dashboard-menu__list">

                <li>
                    <a href="{{ route('user.home') }}" class="dashboard-menu__link {{ request()->routeIs('user.home') ? 'active' : '' }}">
                        <span class="dashboard-menu__icon">
                            <i class="las la-tachometer-alt"></i>
                        </span>
                        <span class="dashboard-menu__text">@lang('Dashboard')</span>
                    </a>
                </li>

                <li>
                    <div class="accordion" id="diposit">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#dipositCollapse"
                                    aria-expanded="{{ request()->routeIs('user.deposit*') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-wallet"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Deposit')
                                    </span>
                                </button>
                            </h2>
                            <div id="dipositCollapse" class="accordion-collapse collapse {{ request()->routeIs('user.deposit*') ? 'show' : '' }}"
                                data-bs-parent="#diposit">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                            <a href="{{ route('user.deposit.index') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.deposit.index') ? 'active' : '' }}">
                                                @lang('Deposit Now')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.deposit.history') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.deposit.history') ? 'active' : '' }}">
                                                @lang('Deposit History')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="accordion" id="withdraw">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#withdrawCollapse"
                                    aria-expanded="{{ request()->routeIs('user.withdraw*') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-money-check"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Withdraw')
                                    </span>
                                </button>
                            </h2>
                            <div id="withdrawCollapse" class="accordion-collapse collapse {{ request()->routeIs('user.withdraw*') ? 'show' : '' }}"
                                data-bs-parent="#withdraw">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                            <a href="{{ route('user.withdraw') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.withdraw') ? 'active' : '' }}">
                                                @lang('Withdraw Now')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.withdraw.history') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.withdraw.history') ? 'active' : '' }}">
                                                @lang('Withdraw History')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                
                
                
                <li>
                    <a href="{{ route('plans') }}"
                        class="dashboard-menu__link {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
                        <span class="dashboard-menu__icon">
                            <i class="las la-money-bill"></i>
                        </span>
                        <span class="dashboard-menu__text">  @if (auth()->user()->expire_date >= now())
                                            @lang('Upgrade Plan')
                                        @else
                                            @lang('Choose Plan')
                                        @endif</span>
                    </a>
                </li>

                <li>
                    <div class="accordion" id="ptc">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#ptcCollapse"
                                    aria-expanded="{{ request()->routeIs('user.ptc*') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-mouse"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Watch ads')
                                    </span>
                                </button>
                            </h2>
                            <div id="ptcCollapse" class="accordion-collapse collapse {{ request()->routeIs('user.ptc*') ? 'show' : '' }}"
                                data-bs-parent="#ptc">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                     <!---    <p style="background-color:tomato;">No ads today (Request for withdrawal).</p> ---->
                                        
                                           <a href="{{ route('user.ptc.index') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.ptc.index') ? 'active' : '' }}">
                                                @lang('Ads')
                                            </a>
                                        </li>
                                        @if (gs('user_ads_post'))
                                            <li>
                                                <a href="{{ route('user.ptc.ads') }}"
                                                    class="dashboard-menu__inner-link {{ request()->routeIs('user.ptc.ads') ? 'active' : '' }}">
                                                    @lang('Post ads')
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('user.ptc.clicks') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.ptc.clicks') ? 'active' : '' }}">
                                                @lang('Watch history')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="{{ route('user.rewards.index') }}"
                        class="dashboard-menu__link {{ request()->routeIs('user.rewards.*') ? 'active' : '' }}">
                        <span class="dashboard-menu__icon">
                            <i class="las la-gift"></i>
                        </span>
                        <span class="dashboard-menu__text">@lang('Daily Rewards')</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.transactions') }}"
                        class="dashboard-menu__link {{ request()->routeIs('user.transactions') ? 'active' : '' }}">
                        <span class="dashboard-menu__icon">
                            <i class="las la-money-bill"></i>
                        </span>
                        <span class="dashboard-menu__text">@lang('Transactions')</span>
                    </a>
                </li>

                @if (gs('balance_transfer'))
                    <li>
                        <a href="{{ route('user.transfer.balance') }}"
                            class="dashboard-menu__link {{ request()->routeIs('user.transfer.balance') ? 'active' : '' }}">
                            <span class="dashboard-menu__icon">
                                <i class="las la-credit-card"></i>
                            </span>
                            <span class="dashboard-menu__text">@lang('Balance Transfer')</span>
                        </a>
                    </li>
                @endif

                <li>
                    <div class="accordion" id="referral">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#referralCollapse"
                                    aria-expanded="{{ request()->routeIs('user.commissions') || request()->routeIs('user.referred') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-gift"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Referral')
                                    </span>
                                </button>
                            </h2>
                            <div id="referralCollapse"
                                class="accordion-collapse collapse {{ request()->routeIs('user.commissions') || request()->routeIs('user.referred') ? 'show' : '' }}"
                                data-bs-parent="#referral">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                            <a href="{{ route('user.commissions') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.commissions') ? 'active' : '' }}">
                                                @lang('Commissions')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.referred') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.referred') ? 'active' : '' }}">
                                                @lang('Referred Users')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="accordion" id="helpDesk">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#helpDeskCollapse"
                                    aria-expanded="{{ request()->routeIs('ticket*') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-question-circle"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Help &amp; Support')
                                    </span>
                                </button>
                            </h2>
                            <div id="helpDeskCollapse" class="accordion-collapse collapse {{ request()->routeIs('ticket*') ? 'show' : '' }}"
                                data-bs-parent="#helpDesk">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                            <a href="{{ route('ticket.index') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('ticket.index') ? 'active' : '' }}">
                                                @lang('Support Ticket')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('ticket.open') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('ticket.open') ? 'active' : '' }}">
                                                @lang('New Ticket')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="accordion" id="account">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accountCollapse"
                                    aria-expanded="{{ request()->routeIs('user.profile.setting') || request()->routeIs('user.change.password') || request()->routeIs('user.twofactor') ? 'true' : 'false' }}">
                                    <span class="accordion-button__icon">
                                        <i class="las la-user-circle"></i>
                                    </span>
                                    <span class="accordion-button__text">
                                        @lang('Account')
                                    </span>
                                </button>
                            </h2>
                            <div id="accountCollapse"
                                class="accordion-collapse collapse {{ request()->routeIs('user.profile.setting') || request()->routeIs('user.change.password') || request()->routeIs('user.twofactor') ? 'show' : '' }}"
                                data-bs-parent="#account">
                                <div class="accordion-body">
                                    <ul class="list dashboard-menu__inner">
                                        <li>
                                            <a href="{{ route('user.profile.setting') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.profile.setting') ? 'active' : '' }}">
                                                @lang('Profile')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.change.password') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.change.password') ? 'active' : '' }}">
                                                @lang('Change Password')
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.twofactor') }}"
                                                class="dashboard-menu__inner-link {{ request()->routeIs('user.twofactor') ? 'active' : '' }}">
                                                @lang('Two Factor')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a href="{{ route('user.logout') }}" class="dashboard-menu__link">
                        <span class="dashboard-menu__icon">
                            <i class="las la-sign-out-alt"></i>
                        </span>
                        <span class="dashboard-menu__text">@lang('Logout')</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


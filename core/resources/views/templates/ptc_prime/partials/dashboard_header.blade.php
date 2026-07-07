<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
        <div class="dashboard-header__left">
            <h4 class="dashboard-header__grettings mb-0">@lang($pageTitle)</h4>
        </div>
        <div class="dashboard-header__right flex-align">
            <a  target="_blank" href="{{route('plans')}}" class="btn btn-outline--base btn--sm">
                <i class="fas fa-seedling"></i> @lang('New Plan')
            </a>
            <div class="user-info">
                <button class="user-info__button flex-align">
                    <span class="user-info__name mb-0"> {{auth()->user()->fullname}} </span>
                </button>
                <ul class="user-info-dropdown">
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="{{ route('user.profile.setting') }}">
                            <span class="icon"><i class="las la-user"></i></span>
                            <span class="text">  @lang('Profile') </span>
                        </a></li>
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="{{ route('user.change.password') }}">
                            <span class="icon"><i class="las la-key"></i></span>
                            <span class="text">  @lang('Change Password') </span>
                        </a></li>
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="{{ route('user.twofactor') }}">
                            <span class="icon"><i class="las la-shield-alt"></i></span>
                            <span class="text">@lang('Two Factor')</span>
                        </a></li>
                    <li class="user-info-dropdown__item"><a class="user-info-dropdown__link" href="{{ route('user.logout') }}">
                            <span class="icon"><i class="las la-sign-out-alt"></i></span>
                            <span class="text">@lang('Logout')</span>
                        </a></li>
                </ul>
            </div>
            <div class="dashboard-body__bar d-lg-none d-block">
                <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
            </div>
        </div>
    </div>
</div>


@extends($activeTemplate . 'layouts.app')

@section('panel')


    @if (!isset($hideHeader) || !$hideHeader)
        @include($activeTemplate . 'partials.header')
    @endif

    @if (!request()->routeIs('home') && !request()->routeIs('user.login') && !request()->routeIs('user.register'))
        @include($activeTemplate . 'partials.breadcrumb')
    @endif

    @yield('content')

    @if (!isset($hideFooter) || !$hideFooter)
        @include($activeTemplate . 'partials.footer')
    @endif
@endsection

@php $hideFooter = true; @endphp
@extends($activeTemplate . 'layouts.app')

@section('panel')
    <div class="page-wrapper">
    
       
        <div class="section--sm">
            <div class="container">
                <div class="row g-4 gy-lg-0">
                    <div class="col-lg-4 col-xl-3">
                        @include($activeTemplate . 'partials.sidenav')
                    </div>
                    <div class="col-lg-8 col-xl-9">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row g-4 g-lg-3 g-xxl-4">
    <div class="col-12">
        <div class="card custom--card">
            <h5 class="card-header">
                <span class="card-header__icon">
                <i class="las la-user-circle"></i>
                </span>
                @lang('Profile Setting')
            </h5>
            <div class="card-body">
                <form  method="post" enctype="multipart/form-data" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label" for="firstname">@lang('First Name')</label>
                        <input type="text" id="firstname" class="form-control form--control" name="firstname" value="{{$user->firstname}}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="lastname">@lang('Last Name')</label>
                        <input type="text" id="lastname" class="form-control form--control" name="lastname" value="{{$user->lastname}}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="email">@lang('E-mail Address')</label>
                        <input id="email" class="form-control form--control" value="{{$user->email}}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">@lang('Mobile Number')</label>
                        <input class="form-control form--control" value="{{$user->mobile}}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="address">@lang('Address')</label>
                        <input type="text" id="address" class="form-control form--control" name="address" value="{{@$user->address}}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="state">@lang('State')</label>
                        <input type="text" id="state" class="form-control form--control" name="state" value="{{@$user->state}}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="zip">@lang('Zip Code')</label>
                        <input type="text" id="zip" class="form-control form--control" name="zip" value="{{@$user->zip}}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="city">@lang('City')</label>
                        <input type="text" id="city" class="form-control form--control" name="city" value="{{@$user->city}}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">@lang('Country')</label>
                        <input class="form-control form--control" value="{{@$user->country_name}}" disabled>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

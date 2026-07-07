@extends($activeTemplate.'layouts.master')
@section('content')
<div class="card custom--card">
    <h5 class="card-header">
        @lang('KYC Form')
    </h5>
    <div class="card-body">
        <form action="{{route('user.kyc.submit')}}" method="post" enctype="multipart/form-data">
            @csrf

            <x-viser-form identifier="act" identifierValue="kyc" />

            <div class="form-group">
                <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit')</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends($activeTemplate . 'layouts.app')
@section('panel')
    <div class="section login-section flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-7 text-center">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h4 class="text--danger">@lang('THE SITE IS UNDER MAINTENANCE')</h4>
                            <img src="{{ getImage(getFilePath('maintenance') . '/' . @$maintenance->data_values->image, getFileSize('maintenance')) }}"
                                alt="@lang('image')" class=" mx-auto mb-5">
                            <p class="mx-auto text-center">@php echo $maintenance->data_values->description @endphp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

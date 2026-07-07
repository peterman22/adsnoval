@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$infos = getContent('contact.element');
$contact = getContent('contact.content',true);


@endphp
<section class="pt-150 pb-150">
    <div class="container">
      <div class="row mb-none-40 justify-content-center">
        @foreach($infos as $info)
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="contact-item">
            <div class="icon">
              @php echo $info->data_values->icon @endphp
            </div>
            <div class="content">
              <h3 class="title">{{ __($info->data_values->title) }}</h3>
              <p>{{ __($info->data_values->content) }}</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        @endforeach
      </div>
      <div class="row justify-content-center mt-100 flex-wrap-reverse">

        <div class="col-lg-6">
            <div class="contact-thumb">
              <img src="{{ frontendImage('contact' , @$contact->data_values->image) }}" alt="">
            </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-form-wrapper pl-5">
            <h4 class="title">{{ __(@$contact->data_values->heading) }}</h4>
            <p>{{ __(@$contact->data_values->subheading) }}</p>
            <form  class="contact-form verify-gcaptcha mt-5" id="contact_form_submit" method="post">
              @csrf
              <div class="row">
                <div class="form-group col-lg-6">
                  <input name="name" type="text" placeholder="@lang('Name')" class="form-control" id="contact-name" value="{{ old('name',@$user->fullname) }}" @if($user && $user->profile_complete) readonly @endif required>
                </div>
                <div class="form-group col-lg-6">
                  <input type="email" name="email" class="form-control" id="contact-email" placeholder="@lang('Email')" value="{{ old('name',@$user->email) }}" @if($user && $user->profile_complete) readonly @endif required>
                </div>
                <div class="form-group col-lg-12">
                  <input type="text" name="subject" class="form-control" id="contact-email" placeholder="@lang('Subject')">
                </div>
                <div class="form-group col-lg-12">
                  <textarea name="message" id="contact-message" class="form-control" placeholder="@lang('Write message')"></textarea>
                </div>
                <x-captcha />
                <div class="col-lg-12">
                  <button type="submit" class="btn btn--base w-100">@lang('send message')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection

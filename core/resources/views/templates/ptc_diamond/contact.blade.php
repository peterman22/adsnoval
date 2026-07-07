@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
	$infos = getContent('contact.element');
	$contact = getContent('contact.content',true);
@endphp
<div class="section--sm">
	<div class="container">
		<div class="row g-4 align-items-center">
			<div class="col-lg-6">
				<img
					src="{{ frontendImage('contact' ,$contact->data_values->image, '705x595') }}"
					alt="image"
					class="img-fluid"
				/>
			</div>
			<div class="col-lg-6">
				<div class="ps-xl-5 contact-form">
					<h3 class="mt-0">{{ __($contact->data_values->heading) }}</h3>
					<form  class="row g-4 verify-gcaptcha" method="post">
						@csrf
						<div class="col-12">
							<label class="form-label" for="name">@lang('Name')</label>
							<input type="text" id="name" name="name" class="form-control form--control" required/>
						</div>
						<div class="col-12">
							<label class="form-label" for="email">@lang('Email')</label>
							<input type="email" id="email" name="email" class="form-control form--control" required/>
						</div>
						<div class="col-12">
							<label class="form-label" for="subject">@lang('Subject')</label>
							<input type="text" id="subject" name="subject" class="form-control form--control" required/>
						</div>
						<div class="col-12">
							<label class="form-label" for="message">@lang('Write message')</label>
							<textarea name="message" id="message" class="form-control form--control" rows="5" required></textarea>
						</div>

						<x-captcha />

						<div class="col-12">
							<button class="btn btn--lg btn--base">@lang('Send message')</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="section--sm">
	<div class="container">
		<div class="row g-4 justify-content-center">
			@foreach($infos as $info)
				<div class="col-md-6 col-lg-4">
					<div class="contact-info">
						<div class="contact-info__icon mx-auto">
							@php echo $info->data_values->icon @endphp
						</div>
						<div class="contact-info__body text-center">
							<h4 class="mt-0">{{ __($info->data_values->title) }}</h4>
							<p class="mb-0">
								{{ __($info->data_values->content) }}
							</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endsection

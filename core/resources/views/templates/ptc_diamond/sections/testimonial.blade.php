@php
    $testimonialCaption = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element');
@endphp
<div class="section--sm">
    <div class="section__head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6 col-xxl-5">
                    <div class="text-center">
                        <span class="section__subtitle">{{ __($testimonialCaption->data_values->subheading) }}</span>
                        <h2 class="section__title m-0">{{ __($testimonialCaption->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="testimonial-slider">
                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-slider__item">
                            <div class="testimonial">
                                <div class="testimonial__head">
                                    <h5 class="testimonial__subject">{{ __($testimonial->data_values->reason) }}</h5>
                                    <div class="testimonial__quote">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                </div>
                                <div class="testimonial__body">
                                    <p class="testimonial__text">
                                        {{ __($testimonial->data_values->comment) }}
                                    </p>
                                </div>
                                <div class="testimonial__footer">
                                    <div class="testimonial__user">
                                        <div class="testimonial__img">
                                            <img src="{{ frontendImage('testimonial', $testimonial->data_values->image) }}" alt="image"
                                                class="testimonial__img-is" />
                                        </div>
                                        <div class="testimonial__content">
                                            <h5 class="testimonial__title">{{ __($testimonial->data_values->name) }}</h5>
                                            <span class="testimonial__sub-title">{{ __($testimonial->data_values->designation) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

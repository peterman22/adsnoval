@php
    $testimonialCaption = getContent('testimonial.content', true);
    $testimonials = getContent('testimonial.element');
@endphp

<!-- testimonial section start -->
<section class="ptb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-header text-center">
                    <h2 class="section-title">{{ __($testimonialCaption->data_values->heading) }}</h2>
                    <p>{{ __($testimonialCaption->data_values->subheading) }}</p>
                </div>
            </div>
        </div><!-- row end -->
        <div class="row">
            <div class="col-lg-12">
                <div class="testimonial-slider">
                    @foreach ($testimonials as $testimonial)
                        <div class="single-slide">
                            <div class="testimonial-card">
                                <div class="testimonial-card__icon">
                                    <i class="las la-quote-left"></i>
                                </div>
                                <p>{{ __($testimonial->data_values->comment) }}</p>
                                <div class="testimonial-card__author d-flex align-items-center gap-3">
                                    <div class="testimonial-card__author-left">
                                        <div class="thumb"><img src="{{ frontendImage('testimonial', $testimonial->data_values->image, '200x200') }}"
                                                alt="image"></div>
                                    </div>
                                    <div class="testimonial-card__author-right">
                                        <h5 class="name">{{ __($testimonial->data_values->name) }}</h5>
                                        <span class="designation">{{ __($testimonial->data_values->designation) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@php
    $featureCaption = getContent('features.content', true);
    $features = getContent('features.element', false, false, true);
@endphp
<div class="section service-section">
    <div class="section__head">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xl-5">
                    <span class="section__subtitle">
                        {{ __($featureCaption->data_values->subheading) }}
                    </span>
                    <h2 class="section__title m-0" s-break='1' data-img-src=" {{ asset($activeTemplateTrue . 'images/title-bg.svg') }}">
                        {{ __($featureCaption->data_values->heading) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($features as $feature)
                <div class="col-md-6 col-lg-4 col-xxl-3">
                    <div class="service-card h-100">
                        <div class="service-card__icon">
                            @php echo $feature->data_values->icon @endphp
                        </div>
                        <div class="service-card__body">
                            <h5 class="service-card__title">
                                {{ __($feature->data_values->title) }}
                            </h5>
                            <p class="service-card__para">
                                {{ __($feature->data_values->content) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

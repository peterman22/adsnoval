@php
    $counterCaption = getContent('counter.content', true);
    $counters = getContent('counter.element');
@endphp
<div class="section--sm">
    <div class="section fact-section"
        style="background-image: url({{ frontendImage('counter', $counterCaption->data_values->background_image, '1920x500') }})">
        <div class="container">
            <div class="row g-4 gy-lg-0 align-items-lg-end">
                <div class="col-lg-6 col-xl-5">
                    <span class="section__subtitle">
                        {{ __($counterCaption->data_values->subheading) }}
                    </span>
                    <h2 class="section__title mt-0" data-img-src="{{ asset($activeTemplateTrue . 'images/title-bg.svg') }}" s-break="-2">
                        {{ __($counterCaption->data_values->heading) }}
                    </h2>
                    <p class="mb-0">
                        {{ __($counterCaption->data_values->description) }}
                    </p>
                </div>
                <div class="col-lg-6 col-xl-7">
                    <ul class="list facts">
                        @foreach ($counters as $counter)
                            <li>
                                <div class="facts-content">
                                    <span class="facts-content__title">
                                        {{ __($counter->data_values->number) }}
                                        <span class="facts-content__title-tail">
                                            {{ __($counter->data_values->range) }}
                                        </span>
                                    </span>
                                    <span class="facts-content__sub-title">
                                        {{ __($counter->data_values->title) }}
                                    </span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

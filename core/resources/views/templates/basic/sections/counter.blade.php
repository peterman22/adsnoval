@php
    $counterCaption = getContent('counter.content', true);
    $counters = getContent('counter.element');
@endphp
<section>
    <div class="overview-area ptb-150 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-header text-center">
                        <h2 class="section-title">{{ __($counterCaption->data_values->heading) }}</h2>
                        <p>{{ __($counterCaption->data_values->sub_heading) }}</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                @foreach ($counters as $counter)
                    <div class="col-md-3 col-6">
                        <div class="counter-card text-center">
                            <div class="counter-card__icon text-white">
                                @php echo $counter->data_values->icon @endphp
                            </div>
                            <div class="counter-card__content">
                                <span class="count-num">{{ __($counter->data_values->number) }}</span>
                                <p>{{ __($counter->data_values->title) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

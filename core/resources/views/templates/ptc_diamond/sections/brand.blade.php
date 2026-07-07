@php
    $elements = getContent('brand.element', false);
@endphp
<div class="client-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="client-slider">
                    @foreach ($elements as $element)
                        <div class="client-slider__item">
                            <img src="{{ frontendImage('brand', $element->data_values->image, '400x150') }}" alt="image" class="client-slider__img">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

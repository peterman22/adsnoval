@php
    $content = getContent('breadcrumb.content', true);
@endphp
<div class="section--sm pt-0">
    <div class="banner" style="background-image: url({{ frontendImage('breadcrumb' , $content->data_values->image, '1920x330') }})">
        <div class="banner__content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-xl-6">
                        <h2 class="mt-0 text--white text-center">
                            {{ __($pageTitle) }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

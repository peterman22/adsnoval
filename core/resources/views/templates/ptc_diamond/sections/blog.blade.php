@php
    $blogCaption = getContent('blog.content', true);
    $blogs = getContent('blog.element', false, 3);
@endphp
<div class="section--sm blog-section">
    <div class="section__head">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6 col-xxl-5">
                    <div class="text-center">
                        <span class="section__subtitle">{{ __($blogCaption->data_values->subheading) }}</span>
                        <h2 class="section__title m-0">{{ __($blogCaption->data_values->heading) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl">
        <div class="row g-4 justify-content-center">
            @foreach ($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <div class="blog-post">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="blog-post__img">
                            <img src="{{ frontendImage('blog', 'thumb_' . $blog->data_values->image, '415x250') }}" alt="image"
                                class="blog-post__img-is">
                        </a>
                        <div class="blog-post__body">
                            <ul class="list list--row align-items-center blog-post__info-list">
                                <li>
                                    <span class="blog-post__info">
                                        {{ showDateTime($blog->created_at, 'F j, Y') }}
                                    </span>
                                </li>
                                <li>
                                    <span class="blog-post__info">
                                        <span class="blog-post__info-icon">
                                            <i class="lar la-clock"></i>
                                        </span>
                                        {{ diffForHumans($blog->created_at) }}
                                    </span>
                                </li>
                            </ul>
                            <h5 class="blog-post__title">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="blog-post__link">
                                    {{ __($blog->data_values->title) }}
                                </a>
                            </h5>
                            <p class="blog-post__description">
                                {{ strLimit(strip_tags($blog->data_values->description), 80) }}
                            </p>
                            <a href="{{ route('blog.details', $blog->slug) }}" class="blog-post__btn">
                                @lang('Read Now')
                                <span class="blog-post__arrow">
                                    <i class="las la-arrow-right"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

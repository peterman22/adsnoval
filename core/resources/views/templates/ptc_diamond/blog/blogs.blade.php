@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @php
        $blogCaption = getContent('blog.content', true);
    @endphp
    <div class="section--sm blog-section">
        <div class="container-xl">
            <div class="row mb-4 g-4 justify-content-center">
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
            <div class="row">
                {{ paginateLinks($blogs) }}
            </div>
        </div>
    </div>
    <!-- blog section end -->
    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif
@endsection

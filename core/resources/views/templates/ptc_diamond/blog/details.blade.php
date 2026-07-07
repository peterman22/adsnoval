@extends($activeTemplate .'layouts.frontend')
@section('content')
<div class="section--sm">
	<div class="container">
		<div class="row g-4 gy-lg-0">
			<div class="col-lg-8">
				<img
					src="{{ frontendImage('blog',$blog->data_values->image, '855x570') }}"
					alt="image"
					class="img-fluid w-100"
				/>
				<h3>{{ __($blog->data_values->title) }}</h3>

                <ul class="list list--row align-items-center blog-post__info-list">
                    <li>
                        <span class="blog-post__info">
                            {{ showDateTime($blog->created_at, 'j F Y') }}
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

				<div>
                    @php echo $blog->data_values->description @endphp
                </div>

                <div class="text-center mt-5 mb-4">
                    <h5 class="caption">@lang('Share This Post')</h5>
                    <ul class="social__links list-unstyled d-flex justify-content-center">
                        <li class="m-2"><a class="p-2 text--dark" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(url()->current()) }}"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="m-2"><a class="p-2 text--dark" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-twitter"></i></a></li>
                        <li class="m-2"><a class="p-2 text--dark" href="https://pinterest.com/pin/create/bookmarklet/?media={{ asset('assets/images/frontend/blog').'/'.$blog->data_values->image }}&url={{urlencode(url()->current()) }}&is_video=[is_video]&description={{$blog->data_values->title}}"><i class="fab fa-pinterest-p"></i></a></li>
                        <li class="m-2"><a class="p-2 text--dark" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{urlencode(url()->current()) }}"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>

                <div class="comment-form-area">
                    <div class="fb-comments" data-href="{{ route('blog.details', $blog->slug) }}" data-width="" data-numposts="5"></div>
                </div>
			</div>
			<div class="col-lg-4">
				<div class="sidebar mb-4">
					<div class="sidebar__head">
						<h5 class="sidebar__head-title">@lang('Recent Posts')</h5>
					</div>
					<div class="sidebar__body">
						<ul class="list">
                            @foreach($latests as $recent)
                                <li>
                                    <div class="recent-post">
                                        <div class="recent-post__img">
                                            <img
                                                src="{{ frontendImage('blog','thumb_'.$recent->data_values->image, '415x250') }}"
                                                alt="image"
                                                class="recent-post__img-is"
                                            />
                                        </div>
                                        <div class="recent-post__content">
                                            <h5 class="recent-post__title">
                                                <a href="{{ route('blog.details',$recent->slug) }}" class="recent-post__title-link">
                                                    {{ __($recent->data_values->title) }}
                                                </a>
                                            </h5>
                                            <span class="recent-post__date">{{ showDateTime($recent->craeted_at, 'j F Y') }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
						</ul>
					</div>
				</div>

				<div class="sidebar">
					<div class="sidebar__head">
						<h5 class="sidebar__head-title">@lang('Most Views')</h5>
					</div>
					<div class="sidebar__body">
						<ul class="list">
                            @foreach($popular as $recent)
                                <li>
                                    <div class="recent-post">
                                        <div class="recent-post__img">
                                            <img
                                                src="{{ frontendImage('blog','thumb_'.$recent->data_values->image, '415x250') }}"
                                                alt="image"
                                                class="recent-post__img-is"
                                            />
                                        </div>
                                        <div class="recent-post__content">
                                            <h5 class="recent-post__title">
                                                <a href="{{ route('blog.details', $recent->slug) }}" class="recent-post__title-link">
                                                    {{ __($recent->data_values->title) }}
                                                </a>
                                            </h5>
                                            <span class="recent-post__date">{{ showDateTime($recent->craeted_at, 'j F Y') }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection

@push('fbComment')
    @php echo loadExtension('fb-comment') @endphp
@endpush

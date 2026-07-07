@php
    $faqCaption = getContent('faq.content',true);
    $faqs = getContent('faq.element');
@endphp
<div class="section faq-section">
	<div class="section__head">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-8 col-xl-6">
					<div class="text-center">
						<span class="section__subtitle">{{ __($faqCaption->data_values->subheading) }}</span>
						<h2 class="section__title m-0">{{ __($faqCaption->data_values->heading) }}</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-10 col-xl-8">
				<div class="accordion custom--accordion" id="faq">
					@foreach($faqs as $key => $faq)
						<div class="accordion-item">
							<h2 class="accordion-header">
								<button
									class="accordion-button collapsed"
									type="button"
									data-bs-toggle="collapse"
									data-bs-target="#collapse{{ $key }}"
									aria-expanded="false"
								>
									{{ __($faq->data_values->question) }}
								</button>
							</h2>
							<div
								id="collapse{{ $key }}"
								class="accordion-collapse collapse"
								data-bs-parent="#faq"
							>
								<div class="accordion-body">
									{{ __($faq->data_values->answer) }}
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>

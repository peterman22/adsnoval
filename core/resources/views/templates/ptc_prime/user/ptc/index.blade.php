@extends($activeTemplate.'layouts.master')
@section('content')
<div class="row">
    @forelse($ads as $ad)

    @if($ad->schedule)
        @php
            $currentTime = now()->format('H:i');
        @endphp

        @if(!collect($ad->schedule)->where('day',strtolower(now()->format('l')))->where('start','<',$currentTime)->where('end','>',$currentTime)->first())
            @continue
        @endif
    @endif
        <div class="col-xl-6 col-md-6 mb-3">
            <div class="card custom--card ptc-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="mt-0">{{ __($ad->title) }}</h6>
                            <span class="fs--14px mt-2">@lang('Ads duration') : {{ $ad->duration }}s</span>
                        </div>
                        <div class="col-4 text-end">
                            <h5 class="text--base mt-0">{{ showAmount($ad->amount) }}</h5>
                            <a href="{{ route('user.ptc.show',encrypt($ad->id.'|'.auth()->user()->id)) }}" target="_blank" class="btn btn btn-outline--base btn--sm">
                             @lang('View')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card custom--card ptc-card">
            <div class="card-body">
                <h4 class="text-center text--base">@lang('Ads not found')</h4>
            </div>
        </div>
    @endforelse

</div>
@endsection


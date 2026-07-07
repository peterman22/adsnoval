@extends($activeTemplate . 'layouts.master')
@section('content')

    <div class="dashboard-table__header d-flex justify-content-end px-0 pt-0">
        <div class="dashboard-table__btn">
            <a href="{{ route('user.ptc.ads') }}" class="btn btn-outline--base btn--sm">
                <i class="las la-list"></i> @lang('My Advertisements')
            </a>
        </div>
    </div>

    <div class="card custom--card">
        <div class="card-body">
            <form class="dashboard-form" role="form" method="POST" action="{{ route('user.ptc.update', $ptc->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Title of the Ad')</label>
                        <input class="form-control form--control" name="title" type="text" value="{{ $ptc->title }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Duration')</label>
                        <div class="input-group">
                            <input class="form-control form--control" name="duration" type="number" value="{{ $ptc->duration }}" required>
                            <div class="input-group-text">@lang('SECONDS')</div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ads_type">@lang('Advertisement Type')</label>
                        <input name="ads_type" type="hidden" value="{{ $ptc->ads_type }}">
                        <div class="pt-3">
                            @php echo $ptc->typeBadge @endphp
                        </div>
                    </div>
                    @if ($ptc->ads_type == 1)
                        <div class="form-group col-md-8">
                            <label class="form-label">@lang('Link') <span class="text-danger">*</span></label>
                            <input class="form-control form--control" name="website_link" type="text" value="{{ $ptc->ads_body }}" placeholder="@lang('http://example.com')">
                        </div>
                    @elseif($ptc->ads_type == 2)
                        <div class="form-group col-md-4">
                            <label class="form-label">@lang('Banner')</label>
                            <input class="form-control form--control" name="banner_image" type="file">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label">@lang('Current Banner') <span class="text-danger">*</span></label>
                            <img class="w-100" src="{{ getImage(getFilePath('ptc') . '/' . $ptc->ads_body) }}">
                        </div>
                    @elseif($ptc->ads_type == 3)
                        <div class="form-group col-md-8">
                            <label class="form-label">@lang('Script') <span class="text-danger">*</span></label>
                            <textarea class="form-control form--control" name="script">{{ $ptc->ads_body }}</textarea>
                        </div>
                    @else
                        <div class="form-group col-md-8">
                            <label class="form-label">@lang('Youtube Embaded Link') <span class="text-danger">*</span></label>
                            <input class="form-control form--control" name="youtube" type="text" value="{{ $ptc->ads_body }}">
                        </div>
                    @endif
                </div>

                <div class="border-top mt-5 pt-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5>@lang('Ad Sechule')</h5>
                        <button class="btn btn--base btn--sm scheduleBtn" type="button"><i class="la la-plus"> </i>@lang('Add')</button>
                    </div>

                    <div id="rowFields">

                        @if ($ptc->schedule)
                            @foreach ($ptc->schedule as $key => $schedule)
                                <div class="form-group">
                                    <div class="row gy-4">
                                        <div class="col-md-4">
                                            <select class="form--control" name="schedule[{{ $key }}][day]" required>
                                                <option value="sunday" @selected($schedule['day'] == 'sunday')>@lang('Sunday')</option>
                                                <option value="monday" @selected($schedule['day'] == 'monday')>@lang('Monday')</option>
                                                <option value="tuesday" @selected($schedule['day'] == 'tuesday')>@lang('Tuesday')</option>
                                                <option value="wednesday" @selected($schedule['day'] == 'wednesday')>@lang('Wednesday')</option>
                                                <option value="thursday" @selected($schedule['day'] == 'thursday')>@lang('Thursday')</option>
                                                <option value="friday" @selected($schedule['day'] == 'friday')>@lang('Friday')</option>
                                                <option value="saturday" @selected($schedule['day'] == 'saturday')>@lang('Saturday')</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control form--control" name="schedule[{{ $key }}][start]" type="time" value="{{ $schedule['start'] }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control form--control" name="schedule[{{ $key }}][end]" type="time" value="{{ $schedule['end'] }}" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn--danger btn--lg w-100 scheduleClose" type="button"><i class="la la-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>

                <div class="form-group col-md-12">
                    <button class="btn btn--base btn--lg w-100" type="submit">@lang('Submit')</button>
                </div>
            </form>
        </div>
    @endsection

    @push('script')
        <script>
            (function($) {
                "use strict";
                var item = {{ $ptc->schedule ? count($ptc->schedule) : 0 }};

                $('.scheduleBtn').on('click', function() {
                    var html = `
                    <div class="form-group">
                        <div class="row gy-4">
                            <div class="col-md-4">
                                <select name="schedule[${item}][day]" class="form-control form--control" required>
                                    <option value="sunday">@lang('Sunday')</option>
                                    <option value="monday">@lang('Monday')</option>
                                    <option value="tuesday">@lang('Tuesday')</option>
                                    <option value="wednesday">@lang('Wednesday')</option>
                                    <option value="thursday">@lang('Thursday')</option>
                                    <option value="friday">@lang('Friday')</option>
                                    <option value="saturday">@lang('Saturday')</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="time" name="schedule[${item}][start]" class="form-control form--control" required>
                            </div>
                            <div class="col-md-3">
                                <input type="time" name="schedule[${item}][end]" class="form-control form--control" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn--danger btn--lg w-100 scheduleClose"><i class="la la-times"></i></button>
                            </div>
                        </div>
                    </div>
                `;

                    item += 1;

                    $('#rowFields').append(html);
                });

                $(document).on('click', '.scheduleClose', function() {
                    $(this).closest('.form-group').remove();
                });

            })(jQuery);
        </script>
    @endpush

@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
            </div>
            <div class="card responsive-filter-card mb-4">
                <div class="card-body">
                    <form >
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label>@lang('TRX/Username')</label>
                                <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Remark')</label>
                                <select class="form-control select2" data-minimum-results-for-search="-1" name="type">
                                    <option value="">@lang('Any')</option>
                                    <option value="deposit_commission">@lang('Deposit Commission')</option>
                                    <option value="plan_subscribe_commission">@lang('Plan Subscribe Commission')</option>
                                    <option value="ptc_view_commission">@lang('Advertisement View Commission')</option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Levels')</label>
                                <select class="form-control select2" data-minimum-results-for-search="-1" name="level">
                                    <option value="">@lang('Any')</option>
                                    @for($i = 1; $i <= $levels; $i++)
                                        <option value="{{ $i }}">{{__(ordinal($i))}} @lang('Level')</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label>@lang('Date')</label>
                                <input name="date" type="search" class="datepicker-here form-control bg--white pe-2 date-range" placeholder="@lang('Start Date - End Date')" autocomplete="off" value="{{ request()->date }}">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> @lang('Filter')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Type - Transaction')</th>
                                <th>@lang('Level - From')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Description')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($commissions as $data)
                                <tr>
                                    <td>{{showDateTime($data->created_at,'Y-m-d')}}</td>
                                    <td>
                                        <span class="fw-bold">{{ $data->userTo->fullname }}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->userTo->id) }}"><span>@</span>{{ $data->userTo->username }}</a> </span>
                                    </td>
                                    <td>
                                        @if($data->type == 'deposit_commission')
                                            <span class="badge badge--success">@lang('Deposit')</span>
                                        @elseif($data->type == 'plan_subscribe_commission')
                                            <span class="badge badge--dark">@lang('Plan Subscribe')</span>
                                        @else
                                            <span class="badge badge--primary">@lang('Ads View')</span>
                                        @endif
                                        <br>
                                        {{__($data->trx)}}
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{__(ordinal($data->level))}}</span>
                                        <br>
                                        <span class="small"> <a href="{{ route('admin.users.detail', $data->userFrom->id) }}"><span>@</span>{{ $data->userFrom->username }}</a> </span>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ gs('cur_sym')}}{{getAmount($data->amount)}}</span>
                                    </td>
                                    <td>
                                        {{__($data->details)}}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if($commissions->hasPages())
                <div class="card-footer">
                    {{ paginateLinks($commissions) }}
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush

@push('script')
    <script>
        (function($){
            "use strict"

            const datePicker = $('.date-range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                },
                showDropdowns: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 15 Days': [moment().subtract(14, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 Months': [moment().subtract(6, 'months').startOf('month'), moment().endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                },
                maxDate: moment()
            });
            const changeDatePickerText = (event, startDate, endDate) => {
                $(event.target).val(startDate.format('MMMM DD, YYYY') + ' - ' + endDate.format('MMMM DD, YYYY'));
            }


            $('.date-range').on('apply.daterangepicker', (event, picker) => changeDatePickerText(event, picker.startDate, picker.endDate));


            if ($('.date-range').val()) {
                let dateRange = $('.date-range').val().split(' - ');
                $('.date-range').data('daterangepicker').setStartDate(new Date(dateRange[0]));
                $('.date-range').data('daterangepicker').setEndDate(new Date(dateRange[1]));
            }

        })(jQuery)
    </script>
@endpush

@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="cmn-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="show-filter mb-3 text-end">
                        <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
                    </div>
                    <div class="card responsive-filter-card mb-4">
                        <div class="card-body">
                            <form>
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1">
                                        <label>@lang('TRX/Username')</label>
                                        <input type="text" name="search" value="{{ request()->search }}" class="form-control">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label>@lang('Remark')</label>
                                        <select class="form-control form--control select2-basic" name="remark" data-minimum-results-for-search="-1">
                                            <option value="">@lang('Any')</option>
                                            <option value="deposit_commission">@lang('Deposit Commission')</option>
                                            <option value="plan_subscribe_commission">@lang('Plan Subscribe Commission')</option>
                                            <option value="ptc_view_commission">@lang('Advertisement View Commission')</option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label>@lang('Levels')</label>
                                        <select class="form-control form--control select2-basic" name="level" data-minimum-results-for-search="-1">
                                            <option value="">@lang('Any')</option>
                                            @for ($i = 1; $i <= $levels; $i++)
                                                <option value="{{ $i }}">{{ __(ordinal($i)) }} @lang('Level')</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--base w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (!blank($commissions))
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive--sm">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>@lang('Transaction')</th>
                                                <th>@lang('Commission From')</th>
                                                <th>@lang('Commission Level')</th>
                                                <th>@lang('Commission Type')</th>
                                                <th>@lang('Amount')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($commissions as $log)
                                                <tr>
                                                    <td>{{ $log->trx }}</td>
                                                    <td>{{ __($log->userFrom->username) }}</td>
                                                    <td>{{ ordinal($log->level) }}</td>
                                                    <td>
                                                        @if ($log->type == 'deposit_commission')
                                                            <span class="badge badge--success">@lang('Deposit')</span>
                                                        @elseif($log->type == 'plan_subscribe_commission')
                                                            <span class="badge badge--dark">@lang('Plan Subscribe')</span>
                                                        @else
                                                            <span class="badge badge--primary">@lang('Ads View')</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ showAmount($log->amount) }} </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body p-0">
                                @include($activeTemplate . 'partials.empty', ['message' => 'Commission not found !'])
                            </div>
                        </div>
                    @endif

                    @if ($commissions->hasPages())
                        {{ paginateLinks($commissions) }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict"
            $('[name=remark]').val('{{ request()->remark }}');
            $('[name=level]').val('{{ request()->level }}');
        })(jQuery);
    </script>
@endpush



@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('style')
    <style>
        span.selection {
            width: 100%;
        }
    </style>
@endpush

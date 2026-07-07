@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="cmn-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="show-filter mb-3 text-end">
                        <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i>
                            @lang('Filter')</button>
                    </div>
                    <div class="card responsive-filter-card mb-4">
                        <div class="card-body">
                            <form>
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="flex-grow-1">
                                        <label class="form-label form--label">@lang('Transaction Number')</label>
                                        <input type="text" name="search" value="{{ request()->search }}" class="form-control form--control">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label form--label">@lang('Type')</label>
                                        <select name="trx_type" class="select2-basic form-control" data-minimum-results-for-search="-1">
                                            <option value="">@lang('All')</option>
                                            <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')
                                            </option>
                                            <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label form--label">@lang('Remark')</label>
                                        <select name="remark" class="select2-basic form-control" data-minimum-results-for-search="-1">
                                            <option value="">@lang('Any')</option>
                                            @foreach ($remarks as $remark)
                                                <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>
                                                    {{ __(keyToTitle($remark->remark)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex-grow-1 align-self-end">
                                        <button class="btn btn--base w-100"><i class="las la-filter"></i>
                                            @lang('Filter')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (!blank($transactions))
                        <div class="card custom--card">
                            <div class="card-body p-0">
                                <div class="table-responsive--sm">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>@lang('Trx')</th>
                                                <th>@lang('Transacted')</th>
                                                <th>@lang('Amount')</th>
                                                <th>@lang('Post Balance')</th>
                                                <th>@lang('Detail')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $trx)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $trx->trx }}</strong>
                                                    </td>

                                                    <td>
                                                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                                                    </td>

                                                    <td class="budget">
                                                        <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                                                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }}

                                                        </span>
                                                    </td>

                                                    <td class="budget">
                                                        {{ showAmount($trx->post_balance) }}
                                                    </td>

                                                    <td>{{ __($trx->details) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body p-0">
                                @include($activeTemplate . 'partials.empty', ['message' => 'Transaction not found'])
                            </div>
                        </div>
                    @endif
                    <div class="mt-4">
                        {{ paginateLinks($transactions) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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

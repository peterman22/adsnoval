@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive--sm">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th >@lang('Name')</th>
                            <th>@lang('Tagline')</th>
                            <th>@lang('Price')</th>
                            <th >@lang('Limit/Day')</th>
                            <th>@lang('Validity')</th>
                            <th>@lang('Referral Commission')</th>
                            <th>@lang('Highlight')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                        <tr>
                            <td>{{$plan->name}}</td>
                            <td>{{strLimit($plan->tagline,30)}}</td>
                            <td class="fw-bold">{{ showAmount($plan->price) }}</td>

                            <td>{{ $plan->daily_limit}} @lang('PTC')</td>
                            <td>{{ $plan->validity}} @lang('Day')</td>
                            <td>@lang('up to') <span class="fw-bold text-primary px-3">{{ $plan->ref_level }} </span>@lang('level')</td>

                            <td>
                                @if($plan->highlight == 1)
                                    <span class="badge badge--success">@lang('Active')</span>
                                    @else
                                    <span class="badge badge--danger">
                                        @lang('Inactive')
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="button--group">
                                <button class="btn btn-outline--primary btn-sm planBtn" data-id="{{ $plan->id }}" data-name="{{ $plan->name }}" data-tagline="{{ $plan->tagline }}" data-price="{{ getAmount($plan->price) }}" data-daily_limit="{{ $plan->daily_limit }}" data-validity="{{ $plan->validity }}" data-highlight="{{ $plan->highlight }}" data-ref_level="{{ $plan->ref_level}}" data-act="Edit">
                                    <i class="la la-pencil"></i>@lang('Edit')
                                </button>

                                @if($plan->status == 1)
                                    <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" data-question="@lang('Are you sure to disable this plan?')" data-action="{{ route('admin.plan.status', $plan->id) }}">
                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-question="@lang('Are you sure to enable this plan?')" data-action="{{ route('admin.plan.status', $plan->id) }}">
                                        <i class="la la-eye"></i> @lang('Enable')
                                    </button>
                                @endif
                                </div>


                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="planModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title"><span class="act"></span> @lang('Subscription Plan')</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <i class="las la-times"></i>
            </button>
            </div>
            <form action="{{ route('admin.plan.save') }}" method="post">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">@lang('Name') </label>
                        <input type="text" class="form-control" name="name" placeholder="@lang('Plan Name')" required>
                    </div>
                    <div class="form-group">
                        <label for="tagline">@lang('Tagline') </label>
                        <input type="text" class="form-control" name="tagline" placeholder="@lang('Tagline')" required>
                    </div>
                    <div class="form-group">
                        <label for="price">@lang('Price') </label>
                        <div class="input-group">
                            <input type="text" class="form-control has-append" name="price" placeholder="@lang('Price of Plan')" required>
                            <div class="input-group-text">{{ gs('cur_text') }}</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Daily Ad Limit')</label>
                        <input type="number" class="form-control" name="daily_limit" placeholder="@lang('Daily Ad Limit')" required>
                    </div>
                    <div class="form-group">
                        <label for="daily_limit">@lang('Validity')</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="validity" placeholder="@lang('Validity')" required>
                            <div class="input-group-text">@lang('Days')</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="details">@lang('Referral Commission') </label>
                        <select name="ref_level" class="form-control select2" data-minimum-results-for-search="-1" required>
                            <option value="">@lang('Select One')</option>
                            <option value="0" > @lang('NO Referral Commission')</option>
                            @for($i = 1; $i <= $levels; $i++)
                            <option value="{{$i}}"> @lang('Up to') {{$i}}  @lang('Level')</option>
                            @endfor
                        </select>

                    </div>

                    <div class="form-group">
                        <label for="highlight">@lang('Highlight')</label>
                        <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="highlight">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-confirmation-modal />

@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm planBtn" data-id="0" data-act="Add" data-bs-toggle="modal" data-bs-target="#planModal"><i class="las la-plus"></i> @lang('Add New')</button>
@endpush


@push('script')
<script>
    (function($){
        "use strict";
        $('.planBtn').on('click', function() {
            var modal = $('#planModal');

            modal.find('.act').text($(this).data('act'));
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=tagline]').val($(this).data('tagline'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=daily_limit]').val($(this).data('daily_limit'));
            modal.find('input[name=validity]').val($(this).data('validity'));
            modal.find('input[name=highlight]').bootstrapToggle($(this).data('highlight') == 1 ? 'on' : 'off');
            modal.find('select[name=ref_level]').val($(this).data('ref_level')).trigger('change');
            if($(this).data('id') == 0){
                modal.find('form')[0].reset();
            }
            modal.modal('show');
        });
    })(jQuery);
</script>
@endpush

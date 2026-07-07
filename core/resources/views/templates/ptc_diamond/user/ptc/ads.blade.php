@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="text-end mb-3">
        <a href="{{ route('user.ptc.create') }}" class="btn btn--base btn-sm">@lang('Create Advertisement')</a>
    </div>
    <div class="card custom--card table-responsive--md mb-4">
        <div class="card-body p-0">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Title')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Viewed')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ads as $ptc)
                        <tr>
                            <td>{{ strLimit($ptc->title, 20) }}</td>
                            <td>
                                @php echo $ptc->typeBadge @endphp
                            </td>
                            <td>{{ $ptc->showed }}</td>

                            <td>
                                @php echo $ptc->statusBadge; @endphp
                            </td>
                            <td>
                                @if ($ptc->status == 3)
                                    <button class="me-1 btn btn--base btn-sm" disabled><i class="la la-pen"></i></button>
                                @else
                                    <a class="me-1 btn btn--base btn-sm" href="{{ route('user.ptc.edit', $ptc->id) }}"><i class="la la-pen"></i></a>
                                @endif
                                @if ($ptc->status == 1 || $ptc->status == 0)
                                    @if ($ptc->status == 1)
                                        <a class="me-1 btn btn--danger btn-sm" href="{{ route('user.ptc.status', $ptc->id) }}"><i
                                                class="la la-eye-slash"></i></a>
                                    @else
                                        <a class="me-1 btn btn--success btn-sm" href="{{ route('user.ptc.status', $ptc->id) }}"><i class="la la-eye"></i></a>
                                    @endif
                                @else
                                    <button class="me-1 btn btn--warning btn-sm" disabled><i class="la la-spinner"></i></button>
                                @endif
                                <a href="javascript:void(0)" class="btn btn--base btn-sm detailBtn" data-title="{{ strLimit($ptc->title, 20) }}"
                                    data-duration="{{ $ptc->duration }} @lang('Sec')" data-max_show="{{ $ptc->max_show }}"
                                    data-viewed="{{ $ptc->showed }}" data-remain="{{ $ptc->remain }}" data-amount="{{ showAmount($ptc->amount) }}"
                                    data-status="{{ $ptc->status }}"
                                    @if ($ptc->status == 3) data-reject_reason="{{ $ptc->reject_reason }}" @endif>
                                    <i class="la la-desktop"></i>
                                </a>
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
    {{ paginateLinks($ads) }}
    <div id="detailModal" class="modal custom--modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group adData mb-2">

                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var html = '';

                var title = $(this).data('title');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Title')</span>
                        <span">${title}</span>
                    </li>`;

                var duration = $(this).data('duration');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Duration')</span>
                        <span">${duration}</span>
                    </li>`;

                var maxShow = $(this).data('max_show');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Maximum Show')</span>
                        <span">${maxShow}</span>
                    </li>`;

                var viewed = $(this).data('viewed');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Viewed')</span>
                        <span">${viewed}</span>
                    </li>`;

                var remain = $(this).data('remain');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Remain')</span>
                        <span">${remain}</span>
                    </li>`;

                var amount = $(this).data('amount');
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Amount')</span>
                        <span">${amount}</span>
                    </li>`;

                var status = $(this).data('status');
                if (status == 3) {
                    var reject_reason = $(this).data('reject_reason');
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>@lang('Reject Reason')</span>
                        <span">${reject_reason}</span>
                    </li>`;
                }
                modal.find('.adData').html(html);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

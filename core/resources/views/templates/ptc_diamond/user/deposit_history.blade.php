@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="mb-3">
        <form>
            <div class="d-flex justify-content-end">
                <div class="input-group w-auto">
                    <input type="text" name="search" class="form-control form--control" value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                    <button class="input-group-text btn btn--base">
                        <i class="las la-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card custom--card table-responsive--md mb-3">
        <div class="card-body p-0">
            <table class="table custom--table">
                <thead class="thead-dark">
                    <tr>
                        <th>@lang('Gateway | Transaction')</th>
                        <th class="text-center">@lang('Initiated')</th>
                        <th class="text-center">@lang('Amount')</th>
                        <th class="text-center">@lang('Conversion')</th>
                        <th class="text-center">@lang('Status')</th>
                        <th>@lang('Details')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-bold"> <span class="text-primary">{{ __($deposit->gateway?->name) }}</span> </span>
                                    <br>
                                    <small> {{ $deposit->trx }} </small>
                                </div>
                            </td>

                            <td class="text-center">
                                <div>
                                    {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div>
                                    {{ showAmount($deposit->amount) }} + <span class="text-danger"
                                        title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                    <br>
                                    <strong title="@lang('Amount with charge')">
                                        {{ showAmount($deposit->amount + $deposit->charge) }}
                                    </strong>
                                </div>
                            </td>
                            <td class="text-center">
                                <div>
                                    1 {{ __(gs('cur_text')) }} = {{ showAmount($deposit->rate, currencyFormat: false) }}
                                    {{ __($deposit->method_currency) }}
                                    <br>
                                    <strong>{{ showAmount($deposit->final_amount) }} {{ __($deposit->method_currency) }}</strong>
                                </div>
                            </td>
                            <td class="text-center">
                                @php echo $deposit->statusBadge @endphp
                            </td>
                            @php
                                $details = [];
                                if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000) {
                                    foreach (@$deposit->detail ?? [] as $key => $info) {
                                        $details[] = $info;
                                        if ($info->type == 'file') {
                                            $details[$key]->value = route(
                                                'user.download.attachment',
                                                encrypt(getFilePath('verify') . '/' . $info->value),
                                            );
                                        }
                                    }
                                }
                            @endphp
                            <td>
                                @if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000)
                                    <a href="javascript:void(0)" class=" btn btn--base btn-sm detailBtn" data-info="{{ json_encode($details) }}"
                                        @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                        <i class="fas fa-desktop"></i>
                                    </a>
                                @else
                                    <button type="button" class=" btn btn--success btn-sm" data-bs-toggle="tooltip" title="@lang('Automatically processed')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                            </td>
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
    {{ paginateLinks($deposits) }}

    {{-- APPROVE MODAL --}}
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
                    <div class="deposit-card">
                        <ul class="deposit-card__list list userData mb-2">
                        </ul>
                        <div class="feedback"></div>
                    </div>
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

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li>
                                <span class="deposit-card__title">${element.name}</span>
                                <span class="deposit-card__amount">${element.value}</span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="cmn-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 ">
                        <div class="mb-3">
                            <form >
                                <div class="d-flex justify-content-end">
                                    <div class="input-group w-auto">
                                        <input type="text" name="search" class="form-control"
                                            value="{{ request()->search }}" placeholder="@lang('Search by transactions')">
                                        <button class="input-group-text bg-primary text-white border-0">
                                            <i class="las la-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!blank(!$withdraws))
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive--sm">
                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>@lang('Gateway | Transaction')</th>
                                                <th class="text-center">@lang('Initiated')</th>
                                                <th class="text-center">@lang('Amount')</th>
                                                <th class="text-center">@lang('Conversion')</th>
                                                <th class="text-center">@lang('Status')</th>
                                                <th>@lang('Action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($withdraws as $withdraw)
                                                <tr>
                                                    <td>
                                                        <span class="fw-bold"><span class="text-primary">
                                                                {{ __(@$withdraw->method->name) }}</span></span>
                                                        <br>
                                                        <small>{{ $withdraw->trx }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ showDateTime($withdraw->created_at) }} <br>
                                                        {{ diffForHumans($withdraw->created_at) }}
                                                    </td>
                                                    <td class="text-center">
                                                       {{ showAmount($withdraw->amount) }} -
                                                        <span class="text-danger"
                                                            title="@lang('charge')">{{ showAmount($withdraw->charge) }}
                                                        </span>
                                                        <br>
                                                        <strong title="@lang('Amount after charge')">
                                                            {{ showAmount($withdraw->amount - $withdraw->charge) }}
                                                        </strong>
                                                    </td>
                                                    <td class="text-center">
                                                        1 {{ __(gs('cur_text')) }} = {{ showAmount($withdraw->rate,currencyFormat:false) }}
                                                        {{ __($withdraw->currency) }}
                                                        <br>
                                                        <strong>{{ showAmount($withdraw->final_amount,currencyFormat:false) }}
                                                            {{ __($withdraw->currency) }}</strong>
                                                    </td>
                                                    <td class="text-center">
                                                        @php echo $withdraw->statusBadge @endphp
                                                    </td>
                                                    <td>
                                                        <button class="btn btn--sm btn--base detailBtn"
                                                            data-user_data="{{ json_encode($withdraw->withdraw_information) }}"
                                                            @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                                            <i class="la la-desktop"></i>
                                                        </button>
                                                    </td>
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
                                @include($activeTemplate . 'partials.empty', [
                                    'message' => 'Withdraw not found',
                                ])
                            </div>
                        </div>
                    @endif

                    @if ($withdraws->hasPages())
                        <div class="card-footer">
                            {{ $withdraws->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    {{-- APPROVE MODAL --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData">

                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
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
                var userData = $(this).data('user_data');
                var html = ``;
                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });
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

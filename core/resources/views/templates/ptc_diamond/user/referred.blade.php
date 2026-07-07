@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="form-group mb-4">
        <label class="form-label" for="referralURL">@lang('Referral Link')</label>
        <div class="input-group">
            <input type="text" value="{{ route('home') }}?reference={{ $user->username }}" class="form-control form-control-lg" id="referralURL" readonly>
            <button class="input-group-text copytext px-3 text--base" id="copyBoard"> <i class="fa fa-copy"></i></button>
        </div>
    </div>
    @if (!blank($refUsers))
        <div class="custom--table-container table-responsive--md mb-4 custom--card">
            <table class="table custom--table">
                <thead>
                    <tr>
                        <th>@lang('Full Name')</th>
                        <th>@lang('User Name')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Mobile')</th>
                        <th>@lang('Plan')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($refUsers as $log)
                        <tr>
                            <td>{{ __($log->fullname) }}</td>
                            <td>{{ __($log->username) }}</td>
                            <td>{{ $log->email }}</td>
                            <td>{{ $log->mobile }}</td>
                            <td>{{ __($log->plan ? $log->plan->name : 'No Plan') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center"> {{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{ paginateLinks($refUsers) }}
        </div>
    @else
        <div class="card custom--card">
            <div class="card-body p-0">
                <div class="card-empty">
                    <div class="card-empty-thumb">
                        <img src="{{ getImage('assets/images/empty_list.png') }}" alt="image">
                    </div>
                    <p class="text-center mb-0">@lang('Data not found')!</p>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('style')
    <style type="text/css">
        .copytextDiv {
            border: 1px solid #00000021;
            cursor: pointer;
        }

        #referralURL {
            border-right: 1px solid #00000021;
        }

        .bg-success-custom {
            background-color: #28a7456e !important;
        }

        .brd-success-custom {
            border: 1px dashed #28a745;
        }
    </style>
@endpush
@push('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
            $('#copyBoard').on("click", function() {
                var copyText = document.getElementById("referralURL");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                iziToast.success({
                    message: "Copied: " + copyText.value,
                    position: "topRight"
                });
            });
        })(jQuery);
    </script>
@endpush

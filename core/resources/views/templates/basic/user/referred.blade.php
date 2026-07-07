@extends($activeTemplate . 'layouts.master')
@section('content')

    <section class="cmn-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-30">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-1">@lang('Refer &amp; Enjoy the Bonus')</h4>
                            <p class="mb-3">@lang("You'll get commission against your referral's activities. Level has been
                                decided by the") <strong><i>{{ __(gs('site_name')) }}</i></strong> @lang("authority. If you reach the level, you'll get
                                commission.")</p>
                            <div class="form-group mb-4">
                                <label>@lang('Referral Link')</label>
                                <div class="copy-link">
                                    <input class="form-control form--control copyURL" id="key" name="key" type="text" value="{{ route('home') }}?reference={{ auth()->user()->username }}" readonly="">
                                    <span class="copy" data-id="key">
                                        <i class="las la-copy"></i> <strong class="copyText">@lang("Copy")</strong>
                                    </span>
                                </div>
                            </div>
                            @if($user->allReferrals->count() > 0 && $maxLevel > 0)
                            <div class="treeview-container">
                                <ul class="treeview">
                                  <li class="items-expanded"> {{ $user->fullname }} ( {{ $user->username }} )
                                        @include($activeTemplate.'partials.under_tree',['user'=>$user,'layer'=>0,'isFirst'=>true])
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('style-lib')
    <link href="{{ asset('assets/global/css/jquery.treeView.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/jquery.treeView.js') }}"></script>
@endpush




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
        .copied::after {
            background-color: #{{gs('base_color') }};
        }

        .copy-link {
            position: relative;
        }

        .copy-link input {
            background: hsl(var(--white)) !important;
        }

        .copy-link span {
            text-align: center;
            position: absolute;
            top: 12px;
            right: 10px;
            cursor: pointer;
            color: #777777;
        }

        .form-check-input:focus {
            box-shadow: none;
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
        (function($) {
            "use strict";
            $('.treeview').treeView();

            $('.copy').on('click', function() {
                var copyText = document.getElementById($(this).data('id'));
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                document.execCommand("copy");
                $(this).find('.copyText').text('Copied');

                setTimeout(() => {
                    $(this).find('.copyText').text('Copy');
                }, 2000);
            });
        })(jQuery);
    </script>
@endpush

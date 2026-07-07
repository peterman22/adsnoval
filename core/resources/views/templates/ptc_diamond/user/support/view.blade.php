@extends($activeTemplate . 'layouts.' . $layout)
@section('content')
    @if ($layout == 'frontend')
        <div class="t-pt-60 t-pb-60">
            <div class="container">
    @endif
    <div class="card custom--card support-ticket">
        <h5 class="card-header card-header-bg d-flex flex-wrap justify-content-between align-items-center">
            <span class="mt-0">
                @php echo $myTicket->statusBadge; @endphp
                [@lang('Ticket')#{{ $myTicket->ticket }}] {{ $myTicket->subject }}
            </span>
            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                <span class="confirmationBtn text-danger c-pointer" data-question="@lang('Are you sure to close this ticket?')"
                    data-action="{{ route('ticket.close', $myTicket->id) }}"><i class="las la-lg la-times-circle"></i>
                </span>
            @endif
        </h5>
        <div class="card-body">
            <form method="post" class="disableSubmission" action="{{ route('ticket.reply', $myTicket->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="message" class="form-control form--control" rows="4" required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <button type="button" class="btn btn--base btn-sm addAttachment my-2"> <i class="fas fa-plus"></i> @lang('Add Attachment') </button>
                        <p class="mb-2"><span class="text--info">@lang('Max 5 files can be uploaded | Maximum upload size is ' . convertToReadableSize(ini_get('upload_max_filesize')) . ' | Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')</span></p>
                        <div class="row fileUploadsContainer">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn--base w-100 my-2" type="submit"><i class="la la-fw la-lg la-reply"></i> @lang('Reply')
                        </button>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer">
            <ul class="list support-list">
                @foreach ($messages as $message)
                    @if ($message->admin_id == 0)
                        <li>
                            <div class="support-card">
                                <div class="support-card__head">
                                    <h5 class="support-card__title">{{ $message->ticket->name }}</h5>
                                    <span class="support-card__date">
                                        <code class="xsm-text text-muted">
                                            <i class="far fa-calendar-alt"></i> @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                        </code>
                                    </span>
                                </div>
                                <div class="support-card__body">
                                    <p class="support-card__body-text text-center text-md-start mb-0">{{ $message->message }}</p>
                                    @if ($message->attachments->count() > 0)
                                        <ul class="list list--row flex-wrap support-card__list justify-content-center justify-content-md-start">
                                            @foreach ($message->attachments as $k => $image)
                                                <li>
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3 support-card__file">
                                                        <span class="support-card__file-icon"><i class="fa fa-file"></i></span>
                                                        <span class="support-card__file-text">@lang('Attachment') {{ ++$k }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @else
                        <li>
                            <div class="support-card" style="background-color: #ffd96729">
                                <div class="support-card__head">
                                    <h5 class="support-card__title">{{ $message->admin->name }}</h5>
                                    <span class="support-card__date">
                                        <code class="xsm-text text-muted">
                                            <i class="far fa-calendar-alt"></i> @lang('Posted on') {{ $message->created_at->format('l, dS F Y @ H:i') }}
                                        </code>
                                    </span>
                                </div>
                                <div class="support-card__body">
                                    <p class="support-card__body-text text-center text-md-start mb-0">{{ $message->message }}</p>
                                    @if ($message->attachments->count() > 0)
                                        <ul class="list list--row flex-wrap support-card__list justify-content-center justify-content-md-start">
                                            @foreach ($message->attachments as $k => $image)
                                                <li>
                                                    <a href="{{ route('ticket.download', encrypt($image->id)) }}" class="me-3 support-card__file">
                                                        <span class="support-card__file-icon"><i class="fa fa-file"></i></span>
                                                        <span class="support-card__file-text">@lang('Attachment') {{ ++$k }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    @if ($layout == 'frontend')
        </div>
        </div>
    @endif

    <x-confirmation-modal customModal="custom--modal" closeButton="btn-close" />

@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .reply-bg {
            background-color: #ffd96729
        }

        .empty-message img {
            width: 120px;
            margin-bottom: 15px;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                    <div class="col-lg-4 col-md-12 removeFileInput">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="file" name="attachments[]" class="form-control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                                <button type="button" class="input-group-text removeFile bg--danger border--danger text-white"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
@endpush

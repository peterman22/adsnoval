@extends($activeTemplate.'layouts.master')
@section('content')
<div class="cmn-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <form  method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>@lang('Username')</label>
                            <input type="text" name="username" class="form-control checkUser">
                            <small class="text-danger usernameExist"></small>
                        </div>
                        <div class="form-group">
                            <label>@lang('Amount') <small class="text--success">( @lang('Charge'): {{ getAmount(gs('bt_fixed')) }} {{ __(gs('cur_text')) }} + {{ getAmount(gs('bt_percent')) }}% )</small></label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" value="{{ old('username') }}" class="form-control">
                                <span class="input-group-text">{{ __(gs('cur_text')) }}</span>
                            </div>
                            <code class="calculation"></code>
                        </div>
                        <button type="submit" class="btn btn--base w-100 mt-3">@lang('Transfer')</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    $('input[name=amount]').on('input',function(){
        var amount = parseFloat($(this).val());
        var calculation = amount + ( parseFloat({{ gs('bt_fixed') }}) + ( amount * parseFloat({{ gs('bt_percent') }}) ) / 100 );
       var info = calculation + ' ' +`{{__(gs('cur_text'))}}` +` @lang('Amount will cut from your account.')`;
        $('.calculation').text(info);
    });

    $('.checkUser').on('focusout',function(e){
        var url = '{{ route('user.checkUser') }}';
        var value = $(this).val();
        var token = '{{ csrf_token() }}';
        var data = {username:value,_token:token}
        $.post(url,data,function(response) {
            if(response.data != false){
                $(`.${response.type}Exist`).text('');
            }else{
                $(`.${response.type}Exist`).text(`${response.type} not found`);
            }
        });
    });
</script>
@endpush

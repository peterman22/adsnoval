@extends($activeTemplate.'layouts.master')
@section('content')
<style>
    .spinner {
        width: 60px;
        height: 60px;
        border: 6px solid #f3f3f3;
        border-top: 6px solid #ff6600; /* Theme color */
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
    
<!-- Loader Overlay -->
<div id="loadingOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background: rgba(0,0,0,0.5); z-index:9999; display:flex; align-items:center; justify-content:center;">
    <div class="spinner"></div>
</div>
    
<div class="card custom--card">

    <div class="card-body">
        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data" id="usdtForm">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary">
                        <p class="mb-0"><i class="las la-info-circle"></i> @lang('You are requesting to make a payment of') <b>{{ showAmount($data['amount'])  }}</b> @lang('.') @lang('Please send the sum of')
                            <b>{{showAmount($data['final_amount'],currencyFormat:false) .' '.$data['method_currency'] }} </b> @lang('for successful payment.')</p>
                    </div>

                    <div class="mb-3">@php echo  $data->gateway->description @endphp</div>

                </div>

                <x-viser-form identifier="id" identifierValue="{{ $gateway->form_id }}" />

                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn--base btn--lg w-100">@lang('Submit payment')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    const form = document.getElementById('usdtForm');
    const loader = document.getElementById('loadingOverlay');

    form.addEventListener('submit', function () {
        loader.style.display = 'flex'; // Show loader on button click (form submit)
    });

    // Hide loader automatically on page load
    window.addEventListener('load', function () {
        loader.style.display = 'none';
    });
</script>
@endsection

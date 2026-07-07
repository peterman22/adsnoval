@extends($activeTemplate.'layouts.app')
@section('panel')
<section class="py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h4 class="m-0 text-center">{{ __(strtoupper($pageTitle)) }}</h4>
                        <hr>
                        @php echo $maintenance->data_values->description @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

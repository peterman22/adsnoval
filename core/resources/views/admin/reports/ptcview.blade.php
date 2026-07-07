@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card  ">
                <div class="card-body p-0">

                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th >@lang('Date')</th>
                                <th >@lang('PTC Ad')</th>
                                <th >@lang('User')</th>
                                <th >@lang('Amount')</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse($ptcviews as $data)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($data->view_date)->format('Y-m-d') }}</td>
                                    <td> <a href="{{route('admin.ptc.edit',$data->ptc->id)}}">{{strLimit($data->ptc->title,20)}}</a></td>
                                    <td><a href="{{ route('admin.users.detail', $data->user->id) }}"><span>@</span>{{ $data->user->username }}</a></td>
                                    <td class="fw-bold">{{ getAmount($data->amount)}} {{__(gs('cur_text'))}} </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($ptcviews->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($ptcviews) }}
                </div>
                @endif
            </div><!-- card end -->
        </div>


    </div>
@endsection

@push('breadcrumb-plugins')
    <form  method="GET" class="form-inline float-sm-end">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Search Username')" value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush

@extends($activeTemplate.'layouts.master')
@section('content')
<div class="custom--table-container table-responsive--md custom--card">
    <table class="table table custom--table">
        <thead>
          <tr>
              <th >@lang('Date')</th>
              <th >@lang('Total Click')</th>
              <th >@lang('Total Earn')</th>
          </tr>
      </thead>
        <tbody>
           @forelse($viewads as $view)
           <tr>
                <td class=""> {{ showDateTime($view->date, 'd M, Y') }} </td>
                <td>{{ $view->total_clicks }}</td>
                <td>
                    {{ showAmount($view->total_earned) }}
                </td>
            </tr>
          @empty
              <tr>
                  <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
              </tr>
          @endforelse
      </tbody>
  </table>
</div>

<div class="mt-4">
    {{paginateLinks($viewads)}}
</div>

@endsection

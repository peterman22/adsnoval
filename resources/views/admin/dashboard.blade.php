<x-admin-layout title="Dashboard">
<div class="grid grid-4" style="margin-bottom:22px">
  <div class="card"><small class="muted">Users</small><h2 style="margin:4px 0 0">{{ number_format($stats['users']) }}</h2></div>
  <div class="card"><small class="muted">User balances</small><h2 style="margin:4px 0 0">${{ number_format($stats['balance'],2) }}</h2></div>
  <div class="card"><small class="muted">Pending deposits</small><h2 style="margin:4px 0 0;color:#fbbf24">{{ $stats['deposits_pending'] }}</h2></div>
  <div class="card"><small class="muted">Pending withdrawals</small><h2 style="margin:4px 0 0;color:#fbbf24">{{ $stats['withdraws_pending'] }}</h2></div>
  <div class="card"><small class="muted">Total deposited</small><h2 style="margin:4px 0 0;color:var(--green)">${{ number_format($stats['deposits_total'],2) }}</h2></div>
  <div class="card"><small class="muted">Total withdrawn</small><h2 style="margin:4px 0 0">${{ number_format($stats['withdraws_total'],2) }}</h2></div>
  <div class="card"><small class="muted">Ads</small><h2 style="margin:4px 0 0">{{ $stats['ads'] }}</h2></div>
  <div class="card"><small class="muted">Ad earnings paid</small><h2 style="margin:4px 0 0">${{ number_format($stats['earned'],2) }}</h2></div>
</div>
<div class="grid grid-2">
  <div class="card"><h3 style="font-size:17px">Recent deposits</h3>
    <table><thead><tr><th>User</th><th>Amount</th><th>Status</th></tr></thead><tbody>
    @forelse($recentDeposits as $d)<tr><td>{{ $d->user?->username }}</td><td>${{ number_format($d->amount,2) }}</td>
    <td>@if($d->status==1)<span class="badge b-ok">Approved</span>@elseif($d->status==3)<span class="badge b-rej">Rejected</span>@else<span class="badge b-pending">Pending</span>@endif</td></tr>
    @empty<tr><td colspan="3" class="muted">None yet</td></tr>@endforelse</tbody></table>
    <a href="{{ route('admin.deposits') }}" class="btn btn-ghost btn-sm" style="margin-top:12px">Manage deposits →</a></div>
  <div class="card"><h3 style="font-size:17px">Recent withdrawals</h3>
    <table><thead><tr><th>User</th><th>Amount</th><th>Status</th></tr></thead><tbody>
    @forelse($recentWithdraws as $w)<tr><td>{{ $w->user?->username }}</td><td>${{ number_format($w->amount,2) }}</td>
    <td>@if($w->status==1)<span class="badge b-ok">Paid</span>@elseif($w->status==3)<span class="badge b-rej">Rejected</span>@else<span class="badge b-pending">Pending</span>@endif</td></tr>
    @empty<tr><td colspan="3" class="muted">None yet</td></tr>@endforelse</tbody></table>
    <a href="{{ route('admin.withdrawals') }}" class="btn btn-ghost btn-sm" style="margin-top:12px">Manage withdrawals →</a></div>
</div>
</x-admin-layout>

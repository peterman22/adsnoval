<x-admin-layout title="Deposits">
<div class="card">
<table><thead><tr><th>User</th><th>Amount</th><th>Method</th><th>TXID</th><th>Proof</th><th>Status</th><th>Action</th></tr></thead><tbody>
@forelse($deposits as $d)
<tr>
<td>{{ $d->user?->username }}</td>
<td>${{ number_format($d->amount,2) }}</td>
<td>{{ $d->method?->name ?? '—' }}</td>
<td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;font-family:monospace;font-size:12px">{{ $d->sender_txid }}</td>
<td>@if($d->proof_path)<a href="{{ asset('storage/'.$d->proof_path) }}" target="_blank">view</a>@else—@endif</td>
<td>@if($d->status==1)<span class="badge b-ok">Approved</span>@elseif($d->status==3)<span class="badge b-rej">Rejected</span>@else<span class="badge b-pending">Pending</span>@endif</td>
<td>@if($d->status==2)
  <form method="POST" action="{{ route('admin.deposits.approve',$d) }}" style="display:inline">@csrf<button class="btn btn-primary btn-sm">Approve</button></form>
  <form method="POST" action="{{ route('admin.deposits.reject',$d) }}" style="display:inline">@csrf<button class="btn btn-ghost btn-sm">Reject</button></form>
@else—@endif</td>
</tr>
@empty<tr><td colspan="7" class="muted">No deposits</td></tr>@endforelse
</tbody></table>
<div style="margin-top:14px">{{ $deposits->links() }}</div>
</div>
</x-admin-layout>

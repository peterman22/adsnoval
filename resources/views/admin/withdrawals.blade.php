<x-admin-layout title="Withdrawals">
<div class="card">
<table><thead><tr><th>User</th><th>Amount</th><th>Currency</th><th>Wallet</th><th>Status</th><th>Action</th></tr></thead><tbody>
@forelse($withdrawals as $w)
<tr>
<td>{{ $w->user?->username }}</td>
<td>${{ number_format($w->amount,2) }}</td>
<td>{{ $w->currency }}</td>
<td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;font-family:monospace;font-size:12px">{{ $w->wallet_address }}</td>
<td>@if($w->status==1)<span class="badge b-ok">Paid</span>@elseif($w->status==3)<span class="badge b-rej">Rejected</span>@else<span class="badge b-pending">Pending</span>@endif</td>
<td>@if($w->status==2)
  <details><summary class="btn btn-primary btn-sm" style="display:inline-block;cursor:pointer">Mark paid</summary>
    <form method="POST" action="{{ route('admin.withdrawals.paid',$w) }}" style="margin-top:8px">@csrf
      <input class="input" name="txid" placeholder="Payout TXID (optional)" style="width:180px;display:inline-block">
      <button class="btn btn-primary btn-sm">Confirm paid</button>
    </form></details>
  <details><summary class="btn btn-ghost btn-sm" style="display:inline-block;cursor:pointer">Reject</summary>
    <form method="POST" action="{{ route('admin.withdrawals.reject',$w) }}" style="margin-top:8px">@csrf
      <textarea class="input" name="note" rows="2" placeholder="Reason for rejection (shown to user)" required style="min-width:220px"></textarea>
      <button class="btn btn-ghost btn-sm" style="margin-top:6px">Reject &amp; refund</button>
    </form></details>
@else
  @if($w->status==3 && $w->admin_note)<span class="muted" style="font-size:12px">✕ {{ $w->admin_note }}</span>@else—@endif
@endif</td>
</tr>
@empty<tr><td colspan="6" class="muted">No withdrawals</td></tr>@endforelse
</tbody></table>
<div style="margin-top:14px">{{ $withdrawals->links() }}</div>
</div>
</x-admin-layout>

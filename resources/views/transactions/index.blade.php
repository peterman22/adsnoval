<x-app-layout title="Transactions">
<div class="card">
<table style="width:100%;border-collapse:collapse">
  <thead><tr>
    <th style="text-align:left;padding:11px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px;text-transform:uppercase">Details</th>
    <th style="text-align:left;padding:11px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px;text-transform:uppercase">Amount</th>
    <th style="text-align:left;padding:11px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px;text-transform:uppercase">Balance</th>
    <th style="text-align:left;padding:11px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px;text-transform:uppercase">Date</th>
  </tr></thead>
  <tbody>
  @forelse($transactions as $t)
    <tr>
      <td style="padding:11px 8px;border-bottom:1px solid var(--border)">{{ $t->details ?? ucfirst(str_replace('_',' ',$t->remark)) }}<br><span class="muted" style="font-size:11px;font-family:monospace">{{ $t->trx }}</span></td>
      <td style="padding:11px 8px;border-bottom:1px solid var(--border);font-weight:700;color:{{ $t->type=='+' ? 'var(--green)' : 'var(--pink)' }}">{{ $t->type }}${{ number_format($t->amount,4) }}</td>
      <td style="padding:11px 8px;border-bottom:1px solid var(--border)">${{ number_format($t->post_balance,2) }}</td>
      <td style="padding:11px 8px;border-bottom:1px solid var(--border)" class="muted">{{ $t->created_at->diffForHumans() }}</td>
    </tr>
  @empty<tr><td colspan="4" class="muted" style="padding:20px">No transactions yet.</td></tr>@endforelse
  </tbody>
</table>
<div style="margin-top:14px">{{ $transactions->links() }}</div>
</div>
</x-app-layout>

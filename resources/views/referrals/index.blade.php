<x-app-layout title="Referrals">
<div class="grid grid-3" style="margin-bottom:22px">
  <div class="card"><small class="muted">Total referrals</small><h2 style="margin:4px 0 0">{{ $count }}</h2></div>
  <div class="card"><small class="muted">Commissions earned</small><h2 style="margin:4px 0 0;color:var(--green)">${{ number_format($earned,2) }}</h2></div>
  <div class="card"><small class="muted">Your code</small><h2 style="margin:4px 0 0" class="grad-text">{{ $user->ref_code }}</h2></div>
</div>
<div class="card" style="margin-bottom:22px">
  <h3 style="font-size:17px">Your referral link</h3>
  <div style="display:flex;gap:10px;flex-wrap:wrap"><input class="input" style="flex:1;min-width:240px" readonly value="{{ route('register',['ref'=>$user->ref_code]) }}"></div>
</div>
<div class="card">
  <h3 style="font-size:17px">Referred users</h3>
  <table style="width:100%;border-collapse:collapse"><thead><tr>
    <th style="text-align:left;padding:10px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px">User</th>
    <th style="text-align:left;padding:10px 8px;border-bottom:1px solid var(--border);color:var(--muted);font-size:12px">Joined</th>
  </tr></thead><tbody>
  @forelse($referrals as $r)<tr><td style="padding:10px 8px;border-bottom:1px solid var(--border)">{{ $r->username }}</td><td style="padding:10px 8px;border-bottom:1px solid var(--border)" class="muted">{{ $r->created_at->diffForHumans() }}</td></tr>
  @empty<tr><td colspan="2" class="muted" style="padding:16px">No referrals yet — share your link!</td></tr>@endforelse
  </tbody></table>
  <div style="margin-top:14px">{{ $referrals->links() }}</div>
</div>
</x-app-layout>

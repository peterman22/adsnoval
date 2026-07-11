<x-admin-layout title="Users">
<div class="card">
  <form method="GET" style="display:flex;gap:10px;margin-bottom:16px">
    <input class="input" name="q" value="{{ $q }}" placeholder="Search username or email" style="max-width:320px">
    <button class="btn btn-ghost">Search</button>
  </form>
  <table><thead><tr><th>User</th><th>Email</th><th>Balance</th><th>Plan</th><th>Refs</th><th>Status</th><th>Action</th></tr></thead><tbody>
  @forelse($users as $u)
  <tr>
    <td><b>{{ $u->username }}</b><br><span class="muted" style="font-size:12px">{{ $u->name }}</span></td>
    <td class="muted">{{ $u->email }}</td>
    <td>${{ number_format($u->balance,2) }}</td>
    <td>{{ $u->plan?->name ?? 'Free' }}</td>
    <td>{{ $u->referrals()->count() }}</td>
    <td>@if($u->is_banned)<span class="badge b-rej">Banned</span>@else<span class="badge b-ok">Active</span>@endif</td>
    <td>
      <details><summary class="btn btn-ghost btn-sm" style="display:inline-block;cursor:pointer">Manage</summary>
        <div style="margin-top:8px">
          <form method="POST" action="{{ route('admin.users.ban',$u) }}" style="margin-bottom:8px">@csrf<button class="btn btn-ghost btn-sm">{{ $u->is_banned ? 'Unban' : 'Ban' }}</button></form>
          <form method="POST" action="{{ route('admin.users.balance',$u) }}">@csrf
            <input class="input" type="number" step="0.01" name="amount" placeholder="+/- amount" style="width:130px;display:inline-block">
            <input class="input" name="note" placeholder="note" style="width:130px;display:inline-block">
            <button class="btn btn-primary btn-sm">Adjust</button>
          </form>
        </div>
      </details>
    </td>
  </tr>
  @empty<tr><td colspan="7" class="muted">No users</td></tr>@endforelse
  </tbody></table>
  <div style="margin-top:14px">{{ $users->links() }}</div>
</div>
</x-admin-layout>

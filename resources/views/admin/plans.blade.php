<x-admin-layout title="Plans">
<div class="grid grid-2" style="align-items:start">
  <div class="card">
    <h3 style="font-size:17px">Add a plan</h3>
    <form method="POST" action="{{ route('admin.plans.store') }}">@csrf
      <div class="field"><label class="label">Name</label><input class="input" name="name" required></div>
      <div class="grid grid-2" style="gap:12px">
        <div class="field"><label class="label">Price ($)</label><input class="input" type="number" step="0.01" name="price" value="0" required></div>
        <div class="field"><label class="label">Daily ad limit</label><input class="input" type="number" name="daily_limit" value="10" required></div>
        <div class="field"><label class="label">Per-ad reward ($)</label><input class="input" type="number" step="0.0001" name="click_value" value="0.01" required></div>
        <div class="field"><label class="label">Validity (days)</label><input class="input" type="number" name="validity_days" value="30" required></div>
        <div class="field"><label class="label">Referral levels (0-3)</label><input class="input" type="number" name="ref_levels" value="1" required></div>
      </div>
      <label style="display:block;margin:6px 0"><input type="checkbox" name="is_popular"> Mark as popular</label>
      <label style="display:block;margin:0 0 14px"><input type="checkbox" name="is_active" checked> Active</label>
      <button class="btn btn-primary btn-block">Create plan</button>
    </form>
  </div>
  <div class="card">
    <h3 style="font-size:17px">All plans ({{ $plans->count() }})</h3>
    @forelse($plans as $p)
      <details style="border-bottom:1px solid var(--border);padding:10px 0">
        <summary style="cursor:pointer;display:flex;justify-content:space-between"><b>{{ $p->name }}</b> <span class="muted">${{ number_format($p->price,2) }} · {{ $p->daily_limit }}/day @if($p->is_popular)⭐@endif @if(!$p->is_active)(off)@endif</span></summary>
        <form method="POST" action="{{ route('admin.plans.update',$p) }}" style="margin-top:10px">@csrf
          <div class="grid grid-2" style="gap:10px">
            <div class="field"><label class="label">Name</label><input class="input" name="name" value="{{ $p->name }}"></div>
            <div class="field"><label class="label">Price</label><input class="input" type="number" step="0.01" name="price" value="{{ $p->price }}"></div>
            <div class="field"><label class="label">Daily limit</label><input class="input" type="number" name="daily_limit" value="{{ $p->daily_limit }}"></div>
            <div class="field"><label class="label">Reward</label><input class="input" type="number" step="0.0001" name="click_value" value="{{ $p->click_value }}"></div>
            <div class="field"><label class="label">Validity</label><input class="input" type="number" name="validity_days" value="{{ $p->validity_days }}"></div>
            <div class="field"><label class="label">Ref levels</label><input class="input" type="number" name="ref_levels" value="{{ $p->ref_levels }}"></div>
          </div>
          <label style="display:block"><input type="checkbox" name="is_popular" @checked($p->is_popular)> Popular</label>
          <label style="display:block;margin-bottom:10px"><input type="checkbox" name="is_active" @checked($p->is_active)> Active</label>
          <button class="btn btn-primary btn-sm">Save</button>
        </form>
        <form method="POST" action="{{ route('admin.plans.destroy',$p) }}" onsubmit="return confirm('Delete plan?')" style="margin-top:8px">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm">Delete</button></form>
      </details>
    @empty<p class="muted">No plans yet.</p>@endforelse
  </div>
</div>
</x-admin-layout>

<x-admin-layout title="Crypto Wallets">
<div class="grid grid-2" style="align-items:start">
  <div class="card">
    <h3 style="font-size:17px">Add a wallet</h3>
    <form method="POST" action="{{ route('admin.crypto.store') }}" enctype="multipart/form-data">@csrf
      <div class="field"><label class="label">Display name</label><input class="input" name="name" placeholder="USDT (TRC20)" required></div>
      <div class="grid grid-2" style="gap:12px">
        <div class="field"><label class="label">Currency</label><input class="input" name="currency" placeholder="USDT" required></div>
        <div class="field"><label class="label">Network</label><input class="input" name="network" placeholder="TRC20"></div>
      </div>
      <div class="field"><label class="label">Wallet address</label><input class="input" name="address" required></div>
      <div class="field"><label class="label">QR code image <span class="muted">(optional)</span></label><input class="input" type="file" name="qr" accept="image/*"></div>
      <div class="grid grid-2" style="gap:12px">
        <div class="field"><label class="label">Min deposit</label><input class="input" type="number" step="0.01" name="min_amount" value="5" required></div>
        <div class="field"><label class="label">Max deposit</label><input class="input" type="number" step="0.01" name="max_amount" value="10000" required></div>
      </div>
      <label style="display:block;margin-bottom:12px"><input type="checkbox" name="is_active" checked> Active</label>
      <button class="btn btn-primary btn-block">Add wallet</button>
    </form>
  </div>
  <div class="card">
    <h3 style="font-size:17px">Wallets ({{ $methods->count() }})</h3>
    @forelse($methods as $m)
      <details style="border-bottom:1px solid var(--border);padding:10px 0">
        <summary style="cursor:pointer;display:flex;justify-content:space-between"><b>{{ $m->name }}</b> <span class="muted">{{ $m->currency }} @if($m->qr_path)📷@endif @if(!$m->is_active)(off)@endif</span></summary>
        <form method="POST" action="{{ route('admin.crypto.update',$m) }}" enctype="multipart/form-data" style="margin-top:10px">@csrf
          <div class="field"><label class="label">Name</label><input class="input" name="name" value="{{ $m->name }}"></div>
          <div class="grid grid-2" style="gap:10px">
            <div class="field"><label class="label">Currency</label><input class="input" name="currency" value="{{ $m->currency }}"></div>
            <div class="field"><label class="label">Network</label><input class="input" name="network" value="{{ $m->network }}"></div>
          </div>
          <div class="field"><label class="label">Address</label><input class="input" name="address" value="{{ $m->address }}"></div>
          @if($m->qr_path)<div style="margin-bottom:10px"><img src="{{ asset('storage/'.$m->qr_path) }}" style="width:90px;border-radius:10px;border:1px solid var(--border)"></div>@endif
          <div class="field"><label class="label">Replace QR code</label><input class="input" type="file" name="qr" accept="image/*"></div>
          <div class="grid grid-2" style="gap:10px">
            <div class="field"><label class="label">Min</label><input class="input" type="number" step="0.01" name="min_amount" value="{{ $m->min_amount }}"></div>
            <div class="field"><label class="label">Max</label><input class="input" type="number" step="0.01" name="max_amount" value="{{ $m->max_amount }}"></div>
          </div>
          <label style="display:block;margin-bottom:10px"><input type="checkbox" name="is_active" @checked($m->is_active)> Active</label>
          <button class="btn btn-primary btn-sm">Save</button>
        </form>
        <form method="POST" action="{{ route('admin.crypto.destroy',$m) }}" onsubmit="return confirm('Delete wallet?')" style="margin-top:8px">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm">Delete</button></form>
      </details>
    @empty<p class="muted">No wallets yet.</p>@endforelse
  </div>
</div>
</x-admin-layout>

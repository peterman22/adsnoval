<x-admin-layout title="Ads">
<div class="grid grid-2" style="align-items:start">
  <div class="card">
    <h3 style="font-size:17px">Add an ad</h3>
    <form method="POST" action="{{ route('admin.ads.store') }}">@csrf
      <div class="field"><label class="label">Title</label><input class="input" name="title" required></div>
      <div class="field"><label class="label">Type</label>
        <select class="input" name="type" required>
          <option value="1">Website (iframe URL)</option>
          <option value="4">YouTube (embed URL)</option>
          <option value="2">Image (image URL)</option>
          <option value="3">Script / HTML</option>
        </select></div>
      <div class="field"><label class="label">Body (URL or HTML)</label><textarea class="input" name="body" rows="3" required></textarea></div>
      <div class="grid grid-2" style="gap:12px">
        <div class="field"><label class="label">Reward ($)</label><input class="input" type="number" step="0.0001" name="reward" value="0.02" required></div>
        <div class="field"><label class="label">Watch seconds</label><input class="input" type="number" name="duration" value="10" required></div>
        <div class="field"><label class="label">Max views</label><input class="input" type="number" name="max_views" value="1000" required></div>
      </div>
      <label style="display:block;margin-bottom:12px"><input type="checkbox" name="active" checked> Active</label>
      <button class="btn btn-primary btn-block">Create ad</button>
    </form>
  </div>
  <div class="card">
    <h3 style="font-size:17px">All ads ({{ $ads->total() }})</h3>
    @forelse($ads as $a)
      <details style="border-bottom:1px solid var(--border);padding:10px 0">
        <summary style="cursor:pointer;display:flex;justify-content:space-between"><b>{{ $a->title }}</b> <span class="muted">${{ number_format($a->reward,2) }} · {{ $a->views_left }}/{{ $a->max_views }} left @if($a->status!=1)(off)@endif</span></summary>
        <form method="POST" action="{{ route('admin.ads.update',$a) }}" style="margin-top:10px">@csrf
          <div class="field"><label class="label">Title</label><input class="input" name="title" value="{{ $a->title }}"></div>
          <div class="field"><label class="label">Type</label><select class="input" name="type">
            <option value="1" @selected($a->type==1)>Website</option><option value="4" @selected($a->type==4)>YouTube</option>
            <option value="2" @selected($a->type==2)>Image</option><option value="3" @selected($a->type==3)>Script</option></select></div>
          <div class="field"><label class="label">Body</label><textarea class="input" name="body" rows="2">{{ $a->body }}</textarea></div>
          <div class="grid grid-2" style="gap:10px">
            <div class="field"><label class="label">Reward</label><input class="input" type="number" step="0.0001" name="reward" value="{{ $a->reward }}"></div>
            <div class="field"><label class="label">Seconds</label><input class="input" type="number" name="duration" value="{{ $a->duration }}"></div>
            <div class="field"><label class="label">Max views</label><input class="input" type="number" name="max_views" value="{{ $a->max_views }}"></div>
          </div>
          <label style="display:block;margin-bottom:10px"><input type="checkbox" name="active" @checked($a->status==1)> Active</label>
          <button class="btn btn-primary btn-sm">Save</button>
        </form>
        <form method="POST" action="{{ route('admin.ads.destroy',$a) }}" onsubmit="return confirm('Delete ad?')" style="margin-top:8px">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm">Delete</button></form>
      </details>
    @empty<p class="muted">No ads yet.</p>@endforelse
    <div style="margin-top:14px">{{ $ads->links() }}</div>
  </div>
</div>
</x-admin-layout>

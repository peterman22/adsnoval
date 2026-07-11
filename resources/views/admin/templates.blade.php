<x-admin-layout title="Email Templates">
<p class="muted">Available placeholders: <code>@{{name}}</code>, <code>@{{username}}</code>, <code>@{{site_name}}</code>, <code>@{{otp}}</code>, <code>@{{amount}}</code>, <code>@{{type}}</code>, <code>@{{balance}}</code>, <code>@{{trx}}</code>, <code>@{{title}}</code>, <code>@{{login_url}}</code></p>
@foreach($templates as $t)
<div class="card" style="margin-bottom:18px">
  <form method="POST" action="{{ route('admin.templates.save',$t) }}">@csrf
    <div style="display:flex;justify-content:space-between;align-items:center"><h3 style="font-size:17px;margin:0">{{ $t->name }} <span class="muted" style="font-size:13px">({{ $t->key }})</span></h3>
      <label><input type="checkbox" name="is_active" @checked($t->is_active)> Active</label></div>
    <div class="field" style="margin-top:12px"><label class="label">Subject</label><input class="input" name="subject" value="{{ $t->subject }}"></div>
    <div class="field"><label class="label">Body (HTML)</label><textarea class="input" name="body" rows="6">{{ $t->body }}</textarea></div>
    <button class="btn btn-primary btn-sm">Save template</button>
  </form>
  <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;margin-top:14px;padding-top:14px;border-top:1px solid var(--border)">
    <a class="btn btn-ghost btn-sm" href="{{ route('admin.templates.preview',$t) }}" target="_blank"><x-icon name="eye" size="15" /> Preview</a>
    <form method="POST" action="{{ route('admin.templates.test',$t) }}" style="display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end;margin:0">@csrf
      <div class="field" style="margin:0"><label class="label">Send test to</label><input class="input" type="email" name="test_email" value="{{ auth('admin')->user()->email ?? '' }}" placeholder="you@example.com" required style="min-width:220px"></div>
      <button class="btn btn-ghost btn-sm"><x-icon name="send" size="15" /> Send test</button>
    </form>
  </div>
</div>
@endforeach
</x-admin-layout>

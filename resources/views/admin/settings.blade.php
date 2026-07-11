<x-admin-layout title="Settings">
<form method="POST" action="{{ route('admin.settings.save') }}">@csrf
<div class="grid grid-2" style="align-items:start">
  <div class="card">
    <h3 style="font-size:17px">Site settings</h3>
    <div class="field"><label class="label">Site name</label><input class="input" name="site_name" value="{{ $s('site_name','AdsNoval') }}"></div>
    <div class="field"><label class="label">Currency symbol</label><input class="input" name="currency_symbol" value="{{ $s('currency_symbol','$') }}"></div>
    <div class="field"><label class="label">Minimum withdrawal</label><input class="input" type="number" step="0.01" name="min_withdraw" value="{{ $s('min_withdraw','5') }}"></div>
    <div class="field"><label class="label">Ref % L1 / L2 / L3</label>
      <div class="grid grid-3" style="gap:8px">
        <input class="input" name="ref_percent_1" value="{{ $s('ref_percent_1','10') }}">
        <input class="input" name="ref_percent_2" value="{{ $s('ref_percent_2','3') }}">
        <input class="input" name="ref_percent_3" value="{{ $s('ref_percent_3','1') }}">
      </div>
    </div>
    <label style="display:block;margin-bottom:8px"><input type="checkbox" name="require_email_verification" value="1" @checked($s('require_email_verification')==='1')> Require email (OTP) verification</label>
  </div>
  <div class="card">
    <h3 style="font-size:17px">SMTP (email)</h3>
    <div class="field"><label class="label">Host</label><input class="input" name="mail_host" value="{{ $s('mail_host') }}" placeholder="smtp.example.com"></div>
    <div class="grid grid-2" style="gap:10px">
      <div class="field"><label class="label">Port</label><input class="input" name="mail_port" value="{{ $s('mail_port','587') }}"></div>
      <div class="field"><label class="label">Encryption</label><input class="input" name="mail_encryption" value="{{ $s('mail_encryption','tls') }}"></div>
    </div>
    <div class="field"><label class="label">Username</label><input class="input" name="mail_username" value="{{ $s('mail_username') }}"></div>
    <div class="field"><label class="label">Password</label><input class="input" type="password" name="mail_password" value="{{ $s('mail_password') }}"></div>
    <div class="field"><label class="label">From address</label><input class="input" name="mail_from_address" value="{{ $s('mail_from_address') }}"></div>
    <div class="field"><label class="label">From name</label><input class="input" name="mail_from_name" value="{{ $s('mail_from_name','AdsNoval') }}"></div>
  </div>
</div>
<button class="btn btn-primary btn-lg" style="margin-top:18px">Save all settings</button>
</form>

<div class="card" style="margin-top:22px">
  <h3 style="font-size:17px;display:flex;align-items:center;gap:8px"><x-icon name="send" size="18" /> Test SMTP connection</h3>
  <p class="muted" style="margin-top:4px">Save your SMTP settings above first, then send a test email to confirm they work. Any error is shown here.</p>
  <form method="POST" action="{{ route('admin.settings.testmail') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;margin-top:8px">@csrf
    <div class="field" style="flex:1;min-width:240px;margin:0"><label class="label">Send test to</label><input class="input" type="email" name="test_email" value="{{ auth('admin')->user()->email ?? '' }}" placeholder="you@example.com" required></div>
    <button class="btn btn-primary">Send test email</button>
  </form>
</div>
</x-admin-layout>

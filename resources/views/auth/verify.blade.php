<x-guest-layout>
<section class="section" style="padding-top:48px"><div class="container" style="max-width:420px">
<div class="card center">
  <div style="color:var(--brand-2)"><x-icon name="mail" size="40" /></div>
  <h1 style="font-size:26px">Verify your email</h1>
  <p>Enter the 6-digit code we sent to @if(!empty($email))<b>{{ $email }}</b>@else your inbox @endif. Your account is created once you verify.</p>
  @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <form method="POST" action="{{ route('verify.submit') }}">@csrf
    <input class="input" name="otp" placeholder="000000" style="text-align:center;font-size:24px;letter-spacing:8px" required autofocus>
    <button class="btn btn-primary btn-block btn-lg" style="margin-top:14px">Verify</button>
  </form>
  <form method="POST" action="{{ route('verify.resend') }}" style="margin-top:10px">@csrf<button class="btn btn-ghost btn-sm">Resend code</button></form>
</div></div></section>
</x-guest-layout>

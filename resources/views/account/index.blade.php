<x-app-layout title="Account">
<div class="grid grid-2" style="align-items:start">
  <div class="card">
    <h3 style="font-size:17px">Profile</h3>
    <form method="POST" action="{{ route('account.profile') }}">@csrf
      <div class="field"><label class="label">Username</label><input class="input" value="{{ $user->username }}" disabled></div>
      <div class="field"><label class="label">Full name</label><input class="input" name="name" value="{{ $user->name }}" required></div>
      <div class="field"><label class="label">Email</label><input class="input" type="email" name="email" value="{{ $user->email }}" required></div>
      <button class="btn btn-primary">Save profile</button>
    </form>
  </div>
  <div class="card">
    <h3 style="font-size:17px">Change password</h3>
    <form method="POST" action="{{ route('account.password') }}">@csrf
      <div class="field"><label class="label">Current password</label><input class="input" type="password" name="current_password" required></div>
      <div class="field"><label class="label">New password</label><input class="input" type="password" name="password" required></div>
      <div class="field"><label class="label">Confirm new password</label><input class="input" type="password" name="password_confirmation" required></div>
      <button class="btn btn-primary">Update password</button>
    </form>
    <hr style="border-color:var(--border);margin:20px 0">
    <div class="muted" style="font-size:13px">
      <p style="margin:0 0 4px"><b style="color:var(--text)">Referral code:</b> {{ $user->ref_code }}</p>
      <p style="margin:0"><b style="color:var(--text)">Member since:</b> {{ $user->created_at->format('M j, Y') }}</p>
    </div>
  </div>
</div>
</x-app-layout>

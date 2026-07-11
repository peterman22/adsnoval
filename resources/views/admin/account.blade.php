<x-admin-layout title="My Account">
<div class="grid grid-2" style="align-items:start">
  <div>
    <div class="card" style="margin-bottom:22px">
      <h3 style="font-size:17px">Profile</h3>
      <form method="POST" action="{{ route('admin.account.profile') }}">@csrf
        <div class="field"><label class="label">Name</label><input class="input" name="name" value="{{ auth('admin')->user()->name }}" required></div>
        <div class="field"><label class="label">Email</label><input class="input" type="email" name="email" value="{{ auth('admin')->user()->email }}" required></div>
        <button class="btn btn-primary">Save profile</button>
      </form>
    </div>
    <div class="card">
      <h3 style="font-size:17px">Change password</h3>
      <form method="POST" action="{{ route('admin.account.password') }}">@csrf
        <div class="field"><label class="label">Current password</label><input class="input" type="password" name="current_password" required></div>
        <div class="field"><label class="label">New password</label><input class="input" type="password" name="password" required></div>
        <div class="field"><label class="label">Confirm new password</label><input class="input" type="password" name="password_confirmation" required></div>
        <button class="btn btn-primary">Update password</button>
      </form>
    </div>
  </div>
  <div>
    <div class="card" style="margin-bottom:22px">
      <h3 style="font-size:17px">Add an admin</h3>
      <form method="POST" action="{{ route('admin.account.add') }}">@csrf
        <div class="field"><label class="label">Name</label><input class="input" name="name" required></div>
        <div class="field"><label class="label">Email</label><input class="input" type="email" name="email" required></div>
        <div class="field"><label class="label">Password</label><input class="input" type="password" name="password" required></div>
        <button class="btn btn-primary">Create admin</button>
      </form>
    </div>
    <div class="card">
      <h3 style="font-size:17px">Admins ({{ $admins->count() }})</h3>
      <table><thead><tr><th>Name</th><th>Email</th><th></th></tr></thead><tbody>
      @foreach($admins as $a)
        <tr>
          <td>{{ $a->name }} @if($a->id===auth('admin')->id())<span class="muted">(you)</span>@endif</td>
          <td class="muted">{{ $a->email }}</td>
          <td>@if($a->id!==auth('admin')->id())<form method="POST" action="{{ route('admin.account.delete',$a) }}" onsubmit="return confirm('Remove this admin?')">@csrf @method('DELETE')<button class="btn btn-ghost btn-sm">Remove</button></form>@endif</td>
        </tr>
      @endforeach
      </tbody></table>
    </div>
  </div>
</div>
</x-admin-layout>

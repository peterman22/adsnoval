<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login</title><link rel="stylesheet" href="{{ asset('assets/css/app.css') }}"></head>
<body><section class="section" style="min-height:100vh;display:flex;align-items:center">
<div class="container" style="max-width:400px"><div class="card">
<div class="center" style="margin-bottom:20px"><a class="brand" style="justify-content:center"><span class="brand-mark">▲</span> Admin</a></div>
@if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif
<form method="POST" action="{{ route('admin.login') }}">@csrf
<div class="field"><label class="label">Email</label><input class="input" type="email" name="email" value="{{ old('email') }}" required autofocus></div>
<div class="field"><label class="label">Password</label><input class="input" type="password" name="password" required></div>
<button class="btn btn-primary btn-block btn-lg">Log in</button></form>
</div></div></section></body></html>

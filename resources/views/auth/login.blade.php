<x-guest-layout>
    <section class="section" style="padding-top:48px">
        <div class="container" style="max-width:440px">
            <div class="card">
                <div class="center" style="margin-bottom:22px">
                    <h1 style="font-size:28px">Welcome back</h1>
                    <p style="margin:0">New here? <a href="{{ route('register') }}">Create an account</a></p>
                </div>

                @if (session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif
                @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="field">
                        <label class="label">Username or email</label>
                        <input class="input" name="login" value="{{ old('login') }}" placeholder="janedoe" required autofocus>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <input class="input" type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <label style="display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);margin-bottom:18px">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <button class="btn btn-primary btn-block btn-lg" type="submit">Log in</button>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>

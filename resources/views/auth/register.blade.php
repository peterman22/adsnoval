<x-guest-layout>
    <section class="section" style="padding-top:48px">
        <div class="container" style="max-width:480px">
            <div class="card">
                <div class="center" style="margin-bottom:22px">
                    <h1 style="font-size:28px">Create your account</h1>
                    <p style="margin:0">Already have one? <a href="{{ route('login') }}">Log in</a></p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
                    </div>
                @endif
                @if (session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="field">
                        <label class="label">Full name</label>
                        <input class="input" name="name" value="{{ old('name') }}" placeholder="Jane Doe" required>
                    </div>
                    <div class="field">
                        <label class="label">Username</label>
                        <input class="input" name="username" value="{{ old('username') }}" placeholder="janedoe" required>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <input class="input" type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="field">
                        <label class="label">Confirm password</label>
                        <input class="input" type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                    @if ($ref)
                        <input type="hidden" name="ref" value="{{ $ref }}">
                        <p style="font-size:13px;color:var(--green)"><x-icon name="check" size="14" /> Referred by code <b>{{ $ref }}</b></p>
                    @endif
                    <button class="btn btn-primary btn-block btn-lg" type="submit">Create account</button>
                </form>
            </div>
        </div>
    </section>
</x-guest-layout>

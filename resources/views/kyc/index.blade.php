<x-app-layout title="Verify Identity">
    @php
        $status = $user->kyc_status ?? 'unverified';
        $badge = [
            'approved' => ['b-ok','Verified','circle-check'],
            'pending'  => ['b-pending','Under review','hourglass'],
            'rejected' => ['b-rej','Rejected','shield'],
            'unverified'=> ['b-pending','Not verified','shield'],
        ][$status] ?? ['b-pending','Not verified','shield'];
    @endphp
    @push('head')
    <style>
        .kyc-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 22px; align-items: start; }
        @media (max-width: 900px){ .kyc-grid { grid-template-columns: 1fr; } }
        .badge { padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; display:inline-flex; align-items:center; gap:6px; }
        .b-pending { background: rgba(251,191,36,.15); color: #fbbf24; }
        .b-ok { background: rgba(52,211,153,.15); color: var(--green); }
        .b-rej { background: rgba(244,114,182,.15); color: var(--pink); }
        .kyc-steps { list-style:none; padding:0; margin:14px 0 0; display:grid; gap:10px; }
        .kyc-steps li { display:flex; gap:10px; align-items:flex-start; color:var(--muted); font-size:14px; }
        .kyc-steps .n { flex:0 0 26px; width:26px; height:26px; border-radius:8px; background:var(--grad-soft); border:1px solid var(--border-2); display:grid; place-items:center; font-weight:800; color:var(--brand-2); font-size:12px; }
    </style>
    @endpush

    <div class="kyc-grid">
        <div class="card">
            <div style="display:flex;justify-content:space-between;align-items:center;gap:12px">
                <h3 style="margin:0;font-size:18px">Identity verification</h3>
                <span class="badge {{ $badge[0] }}"><x-icon name="{{ $badge[2] }}" size="14" /> {{ $badge[1] }}</span>
            </div>

            @if ($status === 'approved')
                <p style="margin-top:14px">Your identity is verified — you have full access to watch ads and earn. Thank you!</p>
            @elseif ($status === 'pending')
                <p style="margin-top:14px">Thanks! Your documents are <b>under review</b>. This usually takes a short while. You'll be able to watch ads once an admin approves your verification.</p>
                @if ($latest)<p class="muted" style="font-size:13px">Submitted {{ $latest->created_at->diffForHumans() }}.</p>@endif
            @else
                @if ($status === 'rejected' && $latest?->note)
                    <div class="alert alert-error" style="margin-top:12px">Your last submission was rejected: <b>{{ $latest->note }}</b><br>Please upload clear documents again.</div>
                @endif
                <p style="margin-top:12px">Verify your identity to unlock ad watching. It's quick and reviewed manually.</p>

                <form method="POST" action="{{ route('kyc.submit') }}" enctype="multipart/form-data" style="margin-top:8px">@csrf
                    <div class="field">
                        <label class="label">Document type</label>
                        <select class="input" name="doc_type" required>
                            <option value="national_id">National ID card</option>
                            <option value="passport">Passport</option>
                            <option value="drivers_license">Driver's license</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="label">Government-issued ID <span class="muted">(photo or PDF)</span></label>
                        <input class="input" type="file" name="id_document" accept="image/*,application/pdf" required>
                    </div>
                    <div class="field">
                        <label class="label">Selfie holding your ID <span class="muted">(photo)</span></label>
                        <input class="input" type="file" name="selfie" accept="image/*" required>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg">Submit for verification</button>
                </form>
            @endif
        </div>

        <div class="card">
            <h3 style="margin:0 0 4px;font-size:16px">How it works</h3>
            <ul class="kyc-steps">
                <li><span class="n">1</span> Upload a clear photo of your government-issued ID.</li>
                <li><span class="n">2</span> Take a selfie holding that same ID.</li>
                <li><span class="n">3</span> Our team reviews and approves your account manually.</li>
                <li><span class="n">4</span> Once approved, you can watch ads and earn.</li>
            </ul>
            <p class="muted" style="font-size:12px;margin-top:16px"><x-icon name="shield" size="13" /> Your documents are stored privately and only used to verify your identity.</p>
        </div>
    </div>
</x-app-layout>

<x-app-layout title="Deposit">
    @push('head')
    <style>
        .dep-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
        @media (max-width: 900px){ .dep-grid { grid-template-columns: 1fr; } }
        .wallet-box { background: rgba(255,255,255,.03); border: 1px dashed var(--border-2); border-radius: 12px; padding: 14px; margin-top: 6px; word-break: break-all; font-family: monospace; font-size: 13px; }
        .method-pill { display:inline-flex; gap:6px; align-items:center; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 11px 8px; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .b-pending { background: rgba(251,191,36,.15); color: #fbbf24; }
        .b-ok { background: rgba(52,211,153,.15); color: var(--green); }
        .b-rej { background: rgba(244,114,182,.15); color: var(--pink); }
    </style>
    @endpush

    <div class="dep-grid">
        <div class="card">
            <h3 style="font-size:18px">Deposit with crypto</h3>
            <p>Send crypto to the wallet below, then submit your transaction details. We verify and credit manually.</p>

            @if ($methods->isEmpty())
                <div class="alert alert-error">No deposit methods are available right now.</div>
            @else
            <form method="POST" action="{{ route('deposits.store') }}" enctype="multipart/form-data" x-data>
                @csrf
                <div class="field">
                    <label class="label">Crypto method</label>
                    <select class="input" name="crypto_method_id" id="method" required>
                        @foreach ($methods as $m)
                            <option value="{{ $m->id }}"
                                data-addr="{{ $m->address }}" data-min="{{ $m->min_amount }}" data-max="{{ $m->max_amount }}" data-cur="{{ $m->currency }}"
                                data-qr="{{ $m->qr_path ? asset('storage/'.$m->qr_path) : '' }}">
                                {{ $m->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label class="label">Send to this address</label>
                    <div class="wallet-box" id="addr">{{ $methods->first()->address }}</div>
                    <div class="muted" style="font-size:12px;margin-top:6px">Min <span id="min">{{ $methods->first()->min_amount }}</span> · Max <span id="max">{{ $methods->first()->max_amount }}</span> ({{ config('app.name') }} credit)</div>
                    <div id="qrbox" style="margin-top:12px;text-align:center;{{ $methods->first()->qr_path ? '' : 'display:none' }}">
                        <img id="qrimg" src="{{ $methods->first()->qr_path ? asset('storage/'.$methods->first()->qr_path) : '' }}" alt="QR" style="width:170px;border-radius:14px;border:1px solid var(--border-2);background:#fff;padding:8px">
                        <div class="muted" style="font-size:12px;margin-top:6px">Scan to pay</div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Amount to credit (in site balance)</label>
                    <input class="input" type="number" step="0.01" name="amount" placeholder="50.00" value="{{ old('amount') }}" required>
                </div>
                <div class="field">
                    <label class="label">Crypto amount you sent <span class="muted">(optional)</span></label>
                    <input class="input" type="number" step="0.00000001" name="sent_amount" placeholder="50" value="{{ old('sent_amount') }}">
                </div>
                <div class="field">
                    <label class="label">Transaction hash / TXID</label>
                    <input class="input" name="sender_txid" placeholder="0x… or blockchain tx hash" value="{{ old('sender_txid') }}" required>
                </div>
                <div class="field">
                    <label class="label">Payment proof <span class="muted">(optional screenshot)</span></label>
                    <input class="input" type="file" name="proof" accept="image/*">
                </div>
                <button class="btn btn-primary btn-block btn-lg">Submit deposit</button>
            </form>
            @endif
        </div>

        <div class="card">
            <h3 style="font-size:18px">Recent deposits</h3>
            @if ($deposits->isEmpty())
                <p class="muted">No deposits yet.</p>
            @else
                <table>
                    <thead><tr><th>Amount</th><th>Method</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach ($deposits as $d)
                            <tr>
                                <td>${{ number_format($d->amount, 2) }}</td>
                                <td>{{ $d->method?->name ?? '—' }}</td>
                                <td>
                                    @if ($d->status == 1) <span class="badge b-ok">Approved</span>
                                    @elseif ($d->status == 3) <span class="badge b-rej">Rejected</span>
                                    @else <span class="badge b-pending">Pending</span> @endif
                                </td>
                                <td class="muted">{{ $d->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        var sel = document.getElementById('method');
        if (sel) sel.addEventListener('change', function(){
            var o = sel.options[sel.selectedIndex];
            document.getElementById('addr').textContent = o.dataset.addr;
            document.getElementById('min').textContent = o.dataset.min;
            document.getElementById('max').textContent = o.dataset.max;
            var qb = document.getElementById('qrbox'), qi = document.getElementById('qrimg');
            if (o.dataset.qr) { qi.src = o.dataset.qr; qb.style.display = ''; } else { qb.style.display = 'none'; }
        });
    </script>
    @endpush
</x-app-layout>

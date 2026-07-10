<x-app-layout title="Withdraw">
    @push('head')
    <style>
        .wd-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; }
        @media (max-width: 900px){ .wd-grid { grid-template-columns: 1fr; } }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 11px 8px; border-bottom: 1px solid var(--border); font-size: 14px; }
        th { color: var(--muted); font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; }
        .badge { padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .b-pending { background: rgba(251,191,36,.15); color: #fbbf24; }
        .b-ok { background: rgba(52,211,153,.15); color: var(--green); }
        .b-rej { background: rgba(244,114,182,.15); color: var(--pink); }
    </style>
    @endpush

    <div class="wd-grid">
        <div class="card">
            <h3 style="font-size:18px">Withdraw to crypto</h3>
            <p>Available balance: <b style="color:var(--brand-2)">${{ number_format($user->balance, 2) }}</b> · Minimum ${{ number_format($minWithdraw, 2) }}</p>

            <form method="POST" action="{{ route('withdrawals.store') }}">
                @csrf
                <div class="field">
                    <label class="label">Amount (site balance)</label>
                    <input class="input" type="number" step="0.01" name="amount" placeholder="{{ number_format($minWithdraw,2) }}" value="{{ old('amount') }}" required>
                </div>
                <div class="field">
                    <label class="label">Payout currency</label>
                    <select class="input" name="currency" required>
                        @forelse ($currencies as $c)
                            <option value="{{ $c->currency }}">{{ $c->name }}</option>
                        @empty
                            <option value="USDT">USDT (TRC20)</option>
                        @endforelse
                    </select>
                </div>
                <div class="field">
                    <label class="label">Your wallet address</label>
                    <input class="input" name="wallet_address" placeholder="Your receiving wallet address" value="{{ old('wallet_address') }}" required>
                </div>
                <button class="btn btn-primary btn-block btn-lg">Request withdrawal</button>
                <p class="muted" style="font-size:12px;margin-top:10px">Withdrawals are reviewed manually and paid to your wallet. The amount is held from your balance while pending.</p>
            </form>
        </div>

        <div class="card">
            <h3 style="font-size:18px">Withdrawal history</h3>
            @if ($withdrawals->isEmpty())
                <p class="muted">No withdrawals yet.</p>
            @else
                <table>
                    <thead><tr><th>Amount</th><th>Currency</th><th>Status</th><th>Date</th></tr></thead>
                    <tbody>
                        @foreach ($withdrawals as $w)
                            <tr>
                                <td>${{ number_format($w->amount, 2) }}</td>
                                <td>{{ $w->currency }}</td>
                                <td>
                                    @if ($w->status == 1) <span class="badge b-ok">Paid</span>
                                    @elseif ($w->status == 3) <span class="badge b-rej">Rejected</span>
                                    @else <span class="badge b-pending">Pending</span> @endif
                                </td>
                                <td class="muted">{{ $w->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>

<x-admin-layout title="KYC Verifications">
@php
    $docLabel = fn($t) => ['national_id'=>'National ID','passport'=>'Passport','drivers_license'=>"Driver's license"][$t] ?? ($t ?: '—');
@endphp

<div class="card" style="margin-bottom:22px">
    <h3 style="font-size:17px;margin-top:0">Pending review ({{ $pending->count() }})</h3>
    @forelse($pending as $v)
        <div style="border-bottom:1px solid var(--border);padding:14px 0">
            <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px;align-items:center">
                <div>
                    <b>{{ $v->user?->username ?? 'user #'.$v->user_id }}</b>
                    <span class="muted" style="font-size:13px">· {{ $v->user?->email }}</span>
                    <div class="muted" style="font-size:12px">{{ $docLabel($v->doc_type) }} · submitted {{ $v->created_at->diffForHumans() }}</div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    <a class="btn btn-ghost btn-sm" href="{{ route('admin.kyc.file',[$v,'id']) }}" target="_blank"><x-icon name="image" size="14" /> View ID</a>
                    <a class="btn btn-ghost btn-sm" href="{{ route('admin.kyc.file',[$v,'selfie']) }}" target="_blank"><x-icon name="user" size="14" /> View selfie</a>
                    <form method="POST" action="{{ route('admin.kyc.approve',$v) }}" style="display:inline">@csrf<button class="btn btn-primary btn-sm"><x-icon name="check" size="14" /> Approve</button></form>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.kyc.reject',$v) }}" style="margin-top:8px;display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end">@csrf
                <div class="field" style="flex:1;min-width:240px;margin:0"><input class="input" name="note" placeholder="Reason for rejection (shown to the user)" required></div>
                <button class="btn btn-ghost btn-sm">Reject</button>
            </form>
        </div>
    @empty
        <p class="muted">No submissions waiting for review.</p>
    @endforelse
</div>

<div class="card">
    <h3 style="font-size:17px;margin-top:0">Recently reviewed</h3>
    <table>
        <thead><tr><th>User</th><th>Document</th><th>Status</th><th>Reason</th><th>Reviewed</th><th>Files</th></tr></thead>
        <tbody>
        @forelse($recent as $v)
            <tr>
                <td>{{ $v->user?->username ?? '—' }}<div class="muted" style="font-size:12px">{{ $v->user?->email }}</div></td>
                <td>{{ $docLabel($v->doc_type) }}</td>
                <td>@if($v->status==1)<span class="badge b-ok">Approved</span>@elseif($v->status==2)<span class="badge b-rej">Rejected</span>@else<span class="badge b-pending">Pending</span>@endif</td>
                <td class="muted" style="font-size:12px">{{ $v->note ?: '—' }}</td>
                <td class="muted">{{ $v->reviewed_at?->diffForHumans() ?? '—' }}</td>
                <td><a href="{{ route('admin.kyc.file',[$v,'id']) }}" target="_blank">ID</a> · <a href="{{ route('admin.kyc.file',[$v,'selfie']) }}" target="_blank">selfie</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="muted">Nothing reviewed yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</x-admin-layout>

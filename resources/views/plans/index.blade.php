<x-app-layout title="Plans">
<div class="grid grid-3">
@forelse($plans as $p)
  <div class="card center" style="position:relative;{{ $p->is_popular ? 'border-color:rgba(255,122,26,.5)' : '' }}">
    @if($p->is_popular)<span class="chip" style="position:absolute;top:-13px;left:50%;transform:translateX(-50%)">POPULAR</span>@endif
    <h3>{{ $p->name }}</h3>
    <div style="font-family:var(--head);font-size:34px;margin:8px 0" class="{{ $p->is_popular ? 'grad-text' : '' }}">{{ $p->price > 0 ? '$'.number_format($p->price,0) : 'Free' }}</div>
    <ul style="list-style:none;padding:0;margin:14px 0;text-align:left">
      <li style="padding:7px 0;border-bottom:1px solid var(--border)"><span style="color:var(--green)"><x-icon name="check" size="14" /></span> {{ $p->daily_limit }} ads / day</li>
      <li style="padding:7px 0;border-bottom:1px solid var(--border)"><span style="color:var(--green)"><x-icon name="check" size="14" /></span> ${{ number_format($p->click_value,3) }} per ad</li>
      <li style="padding:7px 0;border-bottom:1px solid var(--border)"><span style="color:var(--green)"><x-icon name="check" size="14" /></span> {{ $p->validity_days }} days validity</li>
      <li style="padding:7px 0"><span style="color:var(--green)"><x-icon name="check" size="14" /></span> {{ $p->ref_levels }}-level referral</li>
    </ul>
    @if($user->plan_id == $p->id && $user->hasActivePlan())
      <button class="btn btn-ghost btn-block" disabled>Current plan</button>
    @else
      <form method="POST" action="{{ route('plans.buy',$p) }}" onsubmit="return confirm('Buy the {{ $p->name }} plan for ${{ number_format($p->price,2) }}?')">@csrf
        <button class="btn {{ $p->is_popular ? 'btn-primary' : 'btn-ghost' }} btn-block">{{ $p->price > 0 ? 'Buy for $'.number_format($p->price,2) : 'Activate free' }}</button>
      </form>
    @endif
  </div>
@empty<div class="card"><p class="muted">No plans available.</p></div>@endforelse
</div>
</x-app-layout>

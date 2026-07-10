<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password',
        'ref_code', 'referred_by', 'daily_limit',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'plan_expires_at'   => 'datetime',
            'last_check_in'     => 'date',
            'last_spin_at'      => 'date',
            'password'          => 'hashed',
            'balance'           => 'decimal:4',
            'is_banned'         => 'boolean',
        ];
    }

    /* Relationships */
    public function plan(): BelongsTo { return $this->belongsTo(Plan::class); }
    public function transactions(): HasMany { return $this->hasMany(Transaction::class)->latest(); }
    public function adViews(): HasMany { return $this->hasMany(AdView::class); }
    public function deposits(): HasMany { return $this->hasMany(Deposit::class)->latest(); }
    public function withdrawals(): HasMany { return $this->hasMany(Withdrawal::class)->latest(); }
    public function referrals(): HasMany { return $this->hasMany(User::class, 'referred_by'); }
    public function referrer(): BelongsTo { return $this->belongsTo(User::class, 'referred_by'); }

    /* Helpers */
    public function hasActivePlan(): bool
    {
        return $this->plan_id && $this->plan_expires_at && $this->plan_expires_at->isFuture();
    }

    public function effectiveDailyLimit(): int
    {
        return (int) $this->daily_limit + (int) $this->free_ad_credits;
    }

    public function viewsToday(): int
    {
        return $this->adViews()->whereDate('viewed_on', now()->toDateString())->count();
    }
}

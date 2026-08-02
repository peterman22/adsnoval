<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycVerification extends Model {
    protected $guarded = ['id'];
    protected $casts = ['reviewed_at' => 'datetime'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public function statusLabel(): string {
        return [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected'][$this->status] ?? 'Pending';
    }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Withdrawal extends Model {
    protected $guarded = ['id'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function scopePaid($q){ return $q->where('status',1); }
    public function scopePending($q){ return $q->where('status',2); }
}

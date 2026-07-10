<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Deposit extends Model {
    protected $guarded = ['id'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function method(): BelongsTo { return $this->belongsTo(CryptoMethod::class,'crypto_method_id'); }
    public function scopeApproved($q){ return $q->where('status',1); }
    public function scopePending($q){ return $q->where('status',2); }
}

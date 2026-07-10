<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Ad extends Model {
    protected $guarded = ['id'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function scopeActive($q){ return $q->where('status',1)->where('views_left','>',0); }
}

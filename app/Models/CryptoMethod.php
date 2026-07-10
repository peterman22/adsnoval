<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CryptoMethod extends Model {
    protected $guarded = ['id'];
    protected $casts = ['is_active'=>'boolean','rate'=>'decimal:8'];
    public function scopeActive($q){ return $q->where('is_active',true); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Plan extends Model {
    protected $guarded = ['id'];
    protected $casts = ['is_popular'=>'boolean','is_active'=>'boolean','price'=>'decimal:2','click_value'=>'decimal:4'];
    public function scopeActive($q){ return $q->where('is_active',true); }
}

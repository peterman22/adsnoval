<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AdView extends Model {
    protected $guarded = ['id'];
    protected $casts = ['viewed_on'=>'date'];
}

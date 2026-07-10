<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
    protected $guarded = ['id'];
    public static function val(string $key, $default=null){
        return optional(static::where('key',$key)->first())->value ?? $default;
    }
}

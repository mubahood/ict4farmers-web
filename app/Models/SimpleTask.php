<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleTask extends Model
{
    protected $table = 'simple_task';
    use HasFactory;

    public static function boot()
    {
        parent::boot();
        self::updating(function ($m) {
            $m->name = 'Task - '.$m->name;
            return $m;
        });
        self::created(function ($p) {
        });
        static::deleting(function ($model) {
            die("You cannot delete this item.");
        });
    }


    public function category(){
        return $this->belongsTo(TaskCategory::class,'task_category_id');
    }
}

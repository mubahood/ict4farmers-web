<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskCategory extends Model
{
    use HasFactory;


    public static function boot()
    {
        parent::boot();
        self::creating(function ($p) {
        });
        self::created(function ($p) {
        });
        static::deleting(function ($model) {
            die("You cannot delete this item.");
        });
    }
}

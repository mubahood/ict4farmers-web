<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleTask extends Model
{
    protected $table = 'simple_task';
    use HasFactory;
}

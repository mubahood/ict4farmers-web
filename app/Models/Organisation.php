<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

    protected $guarded = [];

    //has Many Farmers Groups
    public function farmers_groups()
    {
        return $this->hasMany(FarmersGroup::class);
    }

    //belongsto self
    public function organizations()
    {
        return $this->hasMany(Organisation::class);
    }
}

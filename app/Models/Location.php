<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;


    public static function get_subcounties()
    {
        $items = [];
        foreach (Location::all() as $key => $v) {
            $parent = ((int)($v->parent));
            $_name = "";
            if ($parent < 1) {
                continue;
            }
            $_name = $v->get_name();
            $items[$v->id] = $_name;
        }
        return $items;
    }

    public function get_name()
    {
        $parent = ((int)($this->parent));
        $_name = "";
        if ($parent > 0) {
            $p = Location::find($parent);
            if ($p != null) {
                $_name = $p->name . ", ";
            }
        }
        return $_name . $this->name;
    }

    public function kids()
    {
        return $this->hasMany(Location::class, 'parent');
    }

    public function mother()
    {
        return $this->belongsTo(Location::class, 'parent');
    }

    public static function get_locations()
    {
        $locations = Location::where([])
            ->orderBy('name', 'Asc')
            ->get();
        $_items = [];
        foreach ($locations as $key => $value) {
            $parent = (int) $value->parent;
            if ($parent > 0) {
                $name = "";
                if ($value->mother != null) {
                    $name = $value->mother->name . " - ";
                }
                $_items[$value->id] = $name . $value->name;
            }
        }
        return $_items;
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            if ($model->kids != null && (!empty($model->kids))) {
                foreach ($model->kids as $key => $kid) {
                    if ($kid->parent_id == $model->id) {
                        $kid->parent_id = 0;
                        $kid->save();
                    }
                }
            }
        });
    }
}

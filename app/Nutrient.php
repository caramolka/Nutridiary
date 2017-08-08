<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nutrient extends Model
{
    public function fooditems()
    {
        return $this->belongsToMany('App\Fooditem')->withPivot('per_100g');
    }
}

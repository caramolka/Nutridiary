<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fooditem extends Model
{
    public function nutrients()
    {
        return $this->belongsToMany('App\Nutrient')->withPivot('per_100g');
    }
}

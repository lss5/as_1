<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function manufacturers()
    {
        return $this->hasMany('App\Models\Manufacturer');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }
}

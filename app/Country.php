<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function manufacturers()
    {
        return $this->hasMany('App\Manufacturer');
    }

    public function companies()
    {
        return $this->hasMany('App\Company');
    }
}

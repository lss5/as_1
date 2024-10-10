<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function profits()
    {
        return $this->hasMany('App\Profit');
    }
}

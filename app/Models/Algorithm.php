<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function profits()
    {
        return $this->hasMany('App\Models\Profit');
    }
}

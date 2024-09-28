<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function manufacturer()
    {
        return $this->belongsTo('App\Manufacturer');
    }

    public function algorithms()
    {
        return $this->belongsToMany('App\Algorithm');
    }

    public function coins()
    {
        return $this->belongsToMany('App\Coin');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

}

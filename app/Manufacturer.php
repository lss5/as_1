<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'url',
        'sort',
        'description',
        'country_id',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }
}

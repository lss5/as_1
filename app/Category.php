<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'uniq_name',
        'sort',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }
}

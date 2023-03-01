<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;

class Category extends Model
{
    protected $fillable = [
        'name',
        'uniq_name',
        'sort',
        'top_menu',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

}

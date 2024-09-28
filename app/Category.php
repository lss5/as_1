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

    public function listings()
    {
        return $this->belongsToMany('App\Listing');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

}

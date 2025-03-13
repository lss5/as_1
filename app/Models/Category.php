<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    const CACHE_KEY_TOP_MENU = 'categories_top_menu';

    protected $guarded = [];

    protected $casts = [
        'top_menu' => 'boolean',
    ];

    public $timestamps = false;

    public function listings(): BelongsToMany
    {
        return $this->belongsToMany(Listing::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->BelongsToMany(Property::class);
    }

    // public function scopeFilter(Builder $builder, QueryFilter $filters)
    // {
    //     return $filters->apply($builder);
    // }

}

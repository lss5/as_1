<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'sort',
        'top_menu',
    ];

    protected $casts = [
        'top_menu' => 'boolean',
    ];

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

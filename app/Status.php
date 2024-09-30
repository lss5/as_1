<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Status extends Model
{
    protected $guarded = [];

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('uniq_name', 'active');
    }
    public function scopeModeration(Builder $query)
    {
        return $query->where('uniq_name', 'moderation');
    }
    public function scopeArchive(Builder $query)
    {
        return $query->where('uniq_name', 'archive');
    }
}

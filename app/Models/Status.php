<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = [];

    public function listings()
    {
        return $this->hasMany('App\Models\Listing');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company');
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

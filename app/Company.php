<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
}

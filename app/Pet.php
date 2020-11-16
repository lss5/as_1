<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    public function animal()
    {
        return $this->belongsTo('App\Animal');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function experiences()
    {
        return $this->hasMany('App\Experience');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}

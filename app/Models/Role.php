<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
}

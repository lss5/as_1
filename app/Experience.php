<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    public function pet()
    {
        return $this->belongsTo('App\Pet');
    }
}

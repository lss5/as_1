<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'updated_time' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function algorithm()
    {
        return $this->belongsTo('App\Algorithm');
    }

}

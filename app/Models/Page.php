<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }

    protected function uniqName(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
        );
    }
}

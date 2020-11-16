<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'cat_id' => 0,
    ];

    public function pets()
    {
        return $this->hasMany('App\Pet');
    }
}

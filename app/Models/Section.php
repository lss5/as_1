<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function pages()
    {
        return $this->hasMany('App\Models\Page')->orderBy('sort');
    }
}

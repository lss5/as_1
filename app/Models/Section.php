<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'uniq_name',
        'sort',
    ];

    public function pages()
    {
        return $this->hasMany('App\Models\Page')->orderBy('sort');
    }
}

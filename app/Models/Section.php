<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    const CACHE_KEY_ALL_PAGES = 'sections_all_pages';

    protected $guarded = [];

    public $timestamps = false;

    public function pages()
    {
        return $this->hasMany('App\Models\Page')->orderBy('sort');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name',
        'list_name',
        'uniq_name',
        'content',
        'section_id',
        'sort',
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Section');
    }
}

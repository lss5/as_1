<?php

namespace App\Models\Property;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Property extends Model
{
    const VALUE_TYPES = [
        'input',
        'select',
    ];

    protected $fillable = [
        'title',
        'unit',
        'sort',
        'value_type',
    ];

    public $timestamps = false;

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}

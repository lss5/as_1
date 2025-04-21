<?php

namespace App\Models\Property;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyValue extends Model
{
    use HasFactory;

    const AVAILABLE_PROPERTY_TYPES = [
        'select',
    ];

    protected $fillable = [
        'value',
        'sort',
    ];

    public $timestamps = false;

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }
}

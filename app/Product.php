<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $guarded = [];

    public static array $hashrates = [
        'hs' => 'H/s',
        'khs' => 'kH/s',
        'mhs' => 'Mh/s',
        'ghs' => 'Gh/s',
        'ths' => 'Th/s',
    ];

    public static array $coolings = [
        'hydro' => 'Hydro',
        'air' => 'Air cooling',
    ];

    public function manufacturer()
    {
        return $this->belongsTo('App\Manufacturer');
    }

    public function properties(): BelongsToMany
    {
        return $this->BelongsToMany(Property::class)
            ->withPivot('value');
    }

    public function algorithms()
    {
        return $this->belongsToMany('App\Algorithm');
    }

    public function coins()
    {
        return $this->belongsToMany('App\Coin');
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public function profits()
    {
        return $this->hasMany('App\Profit');
    }

}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use App\Services\ImportData\WhatToMine;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'moq',
        'power',
        'hashrate',
        'hashrate_name',
        'isnew',
        'mining_time',
        'btc_revenue',
        'revenue',
        'mining_timestamp',
        'mining_direction',
    ];

    public static $hashrates = [
        'ths' => 'Th/s',
        'ghs' => 'Gh/s',
        'mhs' => 'Mh/s',
    ];

    public static $sorting = [
        'created_at' => 'Created',
        'price' => 'Price',
        'hashrate' => 'Hashrate',
        'power' => 'Power',
        'moq' => 'MOQ',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function threads()
    {
        return $this->hasOne('App\Thread', 'parent_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    public function delete()
    {
        $this->forceFill(['active_at' => null])->save();
        return parent::delete();
    }

    public function fill_profit()
    {
        if (!empty($this->hashrate)) {
            $wtm = new WhatToMine();
            $profit = $wtm->getProfit($this);

            if (empty($profit)) {
                return false;
            }

            $this->mining_time = 24;
            $this->btc_revenue = preg_replace('/[^0-9\.,]/','', $profit->btc_revenue);
            $this->revenue = preg_replace('/[^0-9\.,]/','', $profit->revenue);
            $this->mining_timestamp = Carbon::createFromTimestamp($profit->timestamp);
            $this->mining_direction = false;

            return true;
        }

        return false;
    }
}

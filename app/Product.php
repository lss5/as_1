<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'country_id',
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
        'status',
        'status_changed_at',
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

    public static $statuses = [
        'active',
        'moderation',
        'expired',
        'reactivation_rq',
        'banned',
        'canceled',
        'restored',
    ];

    public static $status_default_after_user_edit = 'moderation';

    public static $status_for_edit = [
        'active',
        'moderation',
        'canceled',
        'restored',
    ];

    public static $status_not_change_edit = [
        'moderation',
        'expired',
        'reactivation_rq',
        'banned',
        'restored',
    ];

    public $cost;
    public $profit;
    public $price_th;

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

}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use App\Events\ProductChangeStatus;


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
        'created',
        'active',
        'moderated',
        'moderation',
        'expired',
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
        'created',
        'moderation',
        'expired',
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

    public function setStatus($status)
    {
        $this->fill([
            'status' => $status,
            'status_changed_at' => Carbon::now(),
        ])->save();

        if ($this->status == 'active') {
            $this->fill([
                'active_at' => Carbon::now()->addMonths(config('product.activate_period')),
            ])->save();
        }

        event(New ProductChangeStatus($this));

        return true;
    }

}

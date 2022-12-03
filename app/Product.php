<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use App\Events\ProductChangeStatus;
use App\Jobs\ProductProfitFillJob;
use App\Notifications\ProductChangeStatusNotification;

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
        'algorithm',
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
        'hs' => 'H/s',
        'khs' => 'kH/s',
        'mhs' => 'Mh/s',
        'ghs' => 'Gh/s',
        'ths' => 'Th/s',
    ];

    public static $algorithms = [
        'sha256' => 'ths',
        'scrypt' => 'ghs',
        'x11' => 'ghs',
        'sia' => 'ths',
        'qk' => 'ghs',
        'qb' => 'ghs',
        'mg' => 'ghs',
        'sk' => 'ghs',
        'lbry' => 'ghs',
        'bk14' => 'ths',
        'cn' => 'khs',
        'cst' => 'khs',
        'eq' => 'khs',
        'lre' => 'ghs',
        'bcd' => 'mhs',
        'l2z' => 'mhs',
        'kec' => 'ghs',
        'gro' => 'ghs',
        'esg' => 'ghs',
        'ct31' => 'hs',
        'ct32' => 'hs',
        'kd' => 'ths',
        'hk' => 'ths',
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

    protected static function booted()
    {
        static::created(function ($product) {
            $product->user->notify(new ProductChangeStatusNotification($product));

            if (!empty($product->hashrate)) {
                ProductProfitFillJob::dispatch($product);
            }
        });

        static::updated(function ($product) {
            if (!empty($product->hashrate)) {
                ProductProfitFillJob::dispatch($product);
            }
        });
    }

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

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function delete()
    {
        $this->forceFill(['status' => 'expired'])->save();
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

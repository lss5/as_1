<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use App\Events\ListingChangeStatus;
use App\Jobs\ListingProfitFillJob;
use App\Notifications\ListingChangeStatusNotification;

class Listing extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static $hashrates = [
        'hs' => 'H/s',
        'khs' => 'kH/s',
        'mhs' => 'Mh/s',
        'ghs' => 'Gh/s',
        'ths' => 'Th/s',
    ];

    public static $sorting = [
        'created_at' => 'Created',
        'price' => 'Price',
        'hashrate' => 'Hashrate',
        'power' => 'Power',
        'moq' => 'MOQ',
    ];

    // public $cost;
    // public $profit;
    // public $price_th;

    // protected static function booted()
    // {
    //     static::created(function ($listing) {
    //         $listing->user->notify(new ListingChangeStatusNotification($listing));

    //         if (!empty($listing->hashrate)) {
    //             ListingProfitFillJob::dispatch($listing);
    //         }
    //     });

    //     static::updated(function ($listing) {
    //         if (!empty($listing->hashrate)) {
    //             ListingProfitFillJob::dispatch($listing);
    //         }
    //     });
    // }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\Comment');
    // }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function scopeStatusActive(Builder $query)
    {
        $status = Status::active()->first();
        return $query->where('status_id', $status->id);
    }
    public function scopeStatusModeration(Builder $query)
    {
        $status = Status::moderation()->first();
        return $query->where('status_id', $status->id);
    }
    public function scopeStatusArchive(Builder $query)
    {
        $status = Status::Archive()->first();
        return $query->where('status_id', $status->id);
    }

    // public function threads()
    // {
    //     return $this->hasOne('App\Thread', 'parent_id');
    // }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }

    // public function delete()
    // {
    //     // $this->forceFill(['status' => 'expired'])->save();
    //     return parent::delete();
    // }

    // public function setStatus($status)
    // {
    //     $this->fill([
    //         'status' => $status,
    //         'status_changed_at' => Carbon::now(),
    //     ])->save();

    //     if ($this->status == 'active') {
    //         $this->fill([
    //             'active_at' => Carbon::now()->addMonths(config('product.activate_period')),
    //         ])->save();
    //     }

    //     event(New ListingChangeStatus($this));

    //     return true;
    // }

}

<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Cmgmyr\Messenger\Traits\Messagable;
use App\Notifications\SendVerifyWithQueueNotification;

class User extends Authenticatable implements MustVerifyEmail 
{
    use Notifiable;
    use Messagable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'bio',
        'email',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $limit_product;

    // ----- Relationships ----- //
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function contacts()
    {
        return $this->hasMany('App\Contact');
    }

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public function contact_main()
    {
        return $this->hasMany('App\Contact')->where('ismain', true);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function companies()
    {
        return $this->hasMany('App\Company');
    }

    // ----- Methods ----- //
    public function hasAnyRoles($roles)
    {
        if ($this->roles()->whereIn('uniq_name', $roles)->first()) {
            return true;
        }

        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('uniq_name', $role)->first()) {
            return true;
        }

        return false;
    }

    // public function hasVerifiedGA()
    // {
    //     return !is_null($this->ga_verified_at);
    // }

    // public function markGAVerified()
    // {
    //     return $this->forceFill([
    //         'ga_verified_at' => $this->freshTimestamp(),
    //     ])->save();
    // }

    public function hasVerifiedUser()
    {
        return !is_null($this->user_verified_at);
    }

    public function markUserVerified()
    {
        return $this->forceFill([
            'user_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public static function getFirstAdmin()
    {
        return Role::where('uniq_name', '=', 'admin')->first()->users()->first();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerifyWithQueueNotification());
    }

    public function setLimitProduct()
    {
        if ($this->hasVerifiedGA()) {
            $this->limit_product = config('product.limit_create_product_totp');
        } else {
            $this->limit_product = config('product.limit_create_product');
        }

        return $this;
    }

}

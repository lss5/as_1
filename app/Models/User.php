<?php

namespace App\Models;

use App\Notifications\SendVerifyWithQueueNotification;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use Messagable;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'bio',
        'payments',
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

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function listings()
    {
        return $this->hasMany('App\Models\Listing');
    }

    public function contact_main()
    {
        return $this->hasMany('App\Models\Contact')->where('ismain', true);
    }

    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\Company');
    }

    // ----- Roles ----- //
    public function hasRole($role)
    {
        if ($this->roles()->where('uniq_name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isModerator()
    {
        return $this->hasRole('moder');
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

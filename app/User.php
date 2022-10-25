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

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function products_active()
    {
        return $this->hasMany('App\Product')->whereDate('active_at', '>', Carbon::now());
    }

    public function contact_main()
    {
        return $this->hasMany('App\Contact')->where('ismain', true);
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

    public function hasVerifiedGA()
    {
        return !is_null($this->ga_verified_at);
    }

    public function markGAVerified()
    {
        return $this->forceFill([
            'ga_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function hasVerifiedUser()
    {
        return ! is_null($this->user_verified_at);
    }

    public function markUserVerified()
    {
        return $this->forceFill([
            'user_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public static function getAdmin()
    {
        return Role::where('uniq_name', '=', 'admin')->first()->users()->first();
    }

    public function getDialog($user_id = false, $product_id = false, $type)
    {
        if ($user_id) {
            $parent_user = User::findOrFail($user_id);
            $threads = $this->getThreadsByType($type);
        }
        if ($product_id) {
            $product = Product::findOrFail($product_id);
            $parent_user = User::findOrFail($product->user->id);
            $threads = $this->getThreadsByType($type, $product_id);
        }
        if ($type == 'support' || $type == 'plaint') {
            $parent_user = User::getAdmin();
        }

        if ($threads) {
            $threads = $threads->modelKeys();
            // Search all dialog for parent user with Threads "person" of Auth user
            // and get first Thread
            $parent_user_participant = $parent_user->participants()->whereIn('thread_id', $threads)->first();
            if ($parent_user_participant) {
                return $parent_user_participant->thread_id;
            }
        }
        return false;
    }

    public function getThreadsByType($type, $parent_id = false)
    {
        if ($parent_id) {
            $threads = $this->threads()->where('type', '=', $type)->where('parent_id', '=', $parent_id)->get();
        } else {
            $threads = $this->threads()->where('type', '=', $type)->whereNull('parent_id')->get();
        }
        return $threads;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerifyWithQueueNotification());
    }


}

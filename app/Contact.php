<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public static $types = [
        'tg' => 'Telegram',
        'phone' => 'Telephone',
        'whatsapp' => 'WhatsApp',
        'wechat' => 'WeChat',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function scopeForUser(Builder $query, User $user)
    {
        return $query->where('user_id', $user->id);
    }
}

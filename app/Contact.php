<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'value',
        'type',
        'ismain',
    ];

    public static $types = [
        'tg' => 'Telegram',
        'phone' => 'Telephone',
        'whatsapp' => 'WhatsApp',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

<?php

namespace App\Models;

use App\Events\NewMessageEvent;
use Cmgmyr\Messenger\Models\Message as ParentMessage;
use Illuminate\Support\Facades\Log;

class Message extends ParentMessage
{
    protected static function booted()
    {
        static::created(function ($message) {
            Log::info('Message::created - '.$message->body);
            event(New NewMessageEvent($message));
        });
    }
}

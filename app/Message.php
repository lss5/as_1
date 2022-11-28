<?php

namespace App;

use Cmgmyr\Messenger\Models\Message as ParentMessage;
use App\Events\NewMessageEvent;
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

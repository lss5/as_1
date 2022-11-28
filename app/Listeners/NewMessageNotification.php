<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewMessageEvent;
use App\Notifications\NewMessageNotification as Notification;

class NewMessageNotification implements ShouldQueue
{
    public $delay = 120;

    public function handle(NewMessageEvent $event)
    {
        $participants = $event->message->participants;
        foreach ($participants as $participant) {
            // is Unread this message in Thread
            if ($participant->last_read === null || $event->message->created_at->gt($participant->last_read)) {
                $participant->user->notify(new Notification($event->message));
            }
        }
    }
}

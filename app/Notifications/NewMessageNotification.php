<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.message.new', [
            'thread_subject' => $this->message->thread->subject,
            'message' => $this->message->body,
            'url' => route('messages.show', $this->message->thread),
            'user' => $this->message->user->first_name. ' ' .$this->message->user->last_name,
        ])->subject('New message');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

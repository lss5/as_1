<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListingChangeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $listing;

    public function __construct($listing)
    {
        $this->listing = $listing;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.product.status', [
            'product_title' => $this->listing->title,
            'title' => __('mail.product.status.'.$this->listing->status.'.title'),
            'body' => __('mail.product.status.'.$this->listing->status.'.body'),
            'url' => route('products.show', $this->listing),
            'user' => $this->listing->user->first_name. ' ' .$this->listing->user->last_name,
        ])->subject(__('mail.product.status.'.$this->listing->status.'.subject'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

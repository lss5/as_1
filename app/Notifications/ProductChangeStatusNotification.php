<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductChangeStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.product.status', [
            'product_title' => $this->product->title,
            'title' => __('mail.product.status.'.$this->product->status.'.title'),
            'body' => __('mail.product.status.'.$this->product->status.'.body'),
            'url' => route('products.show', $this->product),
            'user' => $this->product->user->first_name. ' ' .$this->product->user->last_name,
        ])->subject(__('mail.product.status.'.$this->product->status.'.subject'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

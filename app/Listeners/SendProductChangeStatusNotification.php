<?php

namespace App\Listeners;

use App\Events\ProductChangeStatus;
use App\Notifications\ProductChangeStatusNotification;

class SendProductChangeStatusNotification
{
    public function handle(ProductChangeStatus $event)
    {
        $event->product->user->notify(new ProductChangeStatusNotification($event->product));
    }
}

<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use Illuminate\Support\Facades\Event;
use App\Events\ProductChangeStatus;
use App\Listeners\SendProductChangeStatusNotification;
use App\Listeners\NewMessageNotification;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // ProductChangeStatus::class => [
        //     SendProductChangeStatusNotification::class,
        // ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}

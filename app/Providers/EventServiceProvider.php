<?php

namespace App\Providers;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderCancelEvent;
use App\Events\OrderDoneEvent;
use App\Events\OrderMadeEvent;
use App\Listeners\OrderAcceptedListener;
use App\Listeners\OrderCancelListener;
use App\Listeners\OrderDoneListener;
use App\Listeners\OrderMadeListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderMadeEvent::class => [
            OrderMadeListener::class,
        ],
        OrderAcceptedEvent::class => [
            OrderAcceptedListener::class
        ],
        OrderDoneEvent::class => [
            OrderDoneListener::class
        ],
        OrderCancelEvent::class => [
            OrderCancelListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

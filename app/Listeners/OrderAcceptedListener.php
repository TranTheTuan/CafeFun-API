<?php

namespace App\Listeners;

use App\Events\OrderAcceptedEvent;
use App\Notifications\OrderAcceptedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderAcceptedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderAcceptedEvent $event)
    {
        $event->order->user->notify(new OrderAcceptedNotification($event->order));
    }
}

<?php

namespace App\Listeners;

use App\Events\OrderMadeEvent;
use App\Notifications\OrderMadeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderMadeListener implements ShouldQueue
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
    public function handle(OrderMadeEvent $event)
    {
        $restaurant = $event->order->restaurant;
        foreach($restaurant->employees as $employee) {
            foreach($employee->roles as $role) {
                if($role->pivot->role_id === 2) {
                    $employee->user->notify(new OrderMadeNotification($event->order));
                }
            }
        }
    }
}

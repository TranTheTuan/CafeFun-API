@component('mail::message')
@component('mail::panel')
    Congratulation, Your order is done :)
@endcomponent
## User: {{ $order->user->name }}
## Table: {{ $order->table->number }}
## Status: done
## Ordered Foods:
@component('mail::table')
| Food Name     | Quantity      |
| ------------- |:-------------:|
@foreach ($order->foods as $food)
| {{ $food->name }} | {{ $food->pivot->number }} |
@endforeach

<i>Bon appetit !!!</i>

@endcomponent

@endcomponent
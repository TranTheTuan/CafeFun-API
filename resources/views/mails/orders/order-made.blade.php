@component('mail::message')
@component('mail::panel')
    An order is made
@endcomponent
## User: {{ $order->user->name }}
## Table: {{ $order->table->number }}
## Status: pending
## Ordered Foods:
@component('mail::table')
| Food Name     | Quantity      |
| ------------- |:-------------:|
@foreach ($order->foods as $food)
| {{ $food->name }} | {{ $food->pivot->number }} |
@endforeach
@endcomponent

@endcomponent
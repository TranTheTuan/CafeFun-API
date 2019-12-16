@component('mail::message')
@component('mail::panel')
    Your order is being prepared
@endcomponent
## User: {{ $order->user->name }}
## Table: {{ $order->table->number }}
## Status: accepted
## Ordered Foods:
@component('mail::table')
| Food Name     | Quantity      |
| ------------- |:-------------:|
@foreach ($order->foods as $food)
| {{ $food->name }} | {{ $food->pivot->number }} |
@endforeach

<i>please wait a few minutes !!!</i>

@endcomponent

@endcomponent
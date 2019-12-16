@component('mail::message')
@component('mail::panel')
    Sorry, Our restaurant ran out of ingredients to make your order :(
@endcomponent
## User: {{ $order->user->name }}
## Table: {{ $order->table->number }}
## Status: cancelled
## Ordered Foods:
@component('mail::table')
| Food Name     | Quantity      |
| ------------- |:-------------:|
@foreach ($order->foods as $food)
| {{ $food->name }} | {{ $food->pivot->number }} |
@endforeach

<i>You can choose other foods though</i>
<i>Sorry for the inconvenience :(</i>

@endcomponent

@endcomponent
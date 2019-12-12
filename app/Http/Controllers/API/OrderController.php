<?php

namespace App\Http\Controllers\API;

use App\Events\OrderAcceptedEvent;
use App\Events\OrderCancelEvent;
use App\Events\OrderDoneEvent;
use App\Events\OrderMadeEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Order;
use App\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders;
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        try {
            $order = Auth::user()->orders()->findOrFail($id);
            return new OrderResource($order);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        if(Gate::allows('order', $restaurant)) {
            $ordered_table = $request->table;
            $ordered_foods = $request->foods;
            $order = Order::create(['user_id' => Auth::id(),
                                    'table_id' => $ordered_table,
                                    'restaurant_id' => $restaurant->id]);
            foreach($ordered_foods as $ordered_food) {
                $order->foods()->attach($ordered_food[0], ['number' => $ordered_food[1]]);
            }
            event(new OrderMadeEvent($order));
            return new OrderResource(($order));
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function update(Request $request, Restaurant $restaurant, $id)
    {
        if(Gate::allows('handle_order', $restaurant)) {
            try {
                $order = Order::findOrFail($id);
                $status = $request->status;
                $order->update(['status' => $status]);
                if($status == 1) {
                    event(new OrderAcceptedEvent($order));
                } elseif($status == 2) {
                    event(new OrderDoneEvent($order));
                } else {
                    event(new OrderCancelEvent($order));
                }
                return response()->json(['message' => 'updated']);
            } catch (ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()]);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

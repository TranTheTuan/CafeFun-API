<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use App\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $restaurants = $user->favorites->map(function($favorite) {
            return $favorite->restaurant;
        });
        return RestaurantResource::collection($restaurants);
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $favorite = Favorite::firstOrCreate(['user_id' => Auth::id(), 'restaurant_id' => $restaurant->id]);
        return new RestaurantResource($favorite->restaurant);
    }

    public function delete(Restaurant $restaurant)
    {
        $id = Auth::id();
        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('restaurant_id', $restaurant->id)
                            ->delete();
        return response()->json(['message' => 'deleted']);
    }
}

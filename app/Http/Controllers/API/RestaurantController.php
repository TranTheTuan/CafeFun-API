<?php

namespace App\Http\Controllers\API;

use App\Address;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return RestaurantResource::collection($restaurants);
    }

    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant);
    }

    public function filter(Request $request)
    {
        $ward = $request->ward;
        $district = $request->district;
        $provice = $request->province;
        $query = Address::query();
        $query->when($ward, function($q, $ward) {
            return $q->where('ward', $ward);
        });
        $query->when($district, function($q, $district) {
            return $q->where('district', $district);
        });
        $query->when($provice, function($q, $provice) {
            return $q->where('province', $provice);
        });
        $addresses = $query->get();
        $restaurants = $addresses->map(function($address) {
            return $address->restaurant;
        });
        return RestaurantResource::collection($restaurants);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Food;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Http\Resources\FoodResource;
use App\Restaurant;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $foods = $restaurant->foods;
        return FoodResource::collection($foods);
    }

    public function show(Restaurant $restaurant, $food)
    {
        try {
            $searched_food = $restaurant->foods()->findOrFail($food);
            return new FoodResource($searched_food);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function store(FoodRequest $request, Restaurant $restaurant)
    {
        if(Gate::allows('manage', $restaurant)) {
            $food = $restaurant->foods()->create($request->all());
            return new FoodResource($food);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function update(Request $request, Restaurant $restaurant, $food)
    {
        if(Gate::allows('manage', $restaurant)) {
            try {
                $food = $restaurant->foods()->findOrFail($food);
                $food->update($request->all());
                return new FoodResource($food);
            } catch(ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()], 404);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function delete(Restaurant $restaurant, $food)
    {
        if(Gate::allows('manage', $restaurant)) {
            try {
                $food = $restaurant->foods()->findOrFail($food);
                $food->delete();
                return response()->json(['message' => 'food deleted']);
            } catch(ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()], 404);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

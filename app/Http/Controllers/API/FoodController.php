<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function show(Restaurant $restaurant, $id)
    {
        try {
            $searched_food = $restaurant->foods()->findOrFail($id);
            return new FoodResource($searched_food);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        if(Gate::allows('manage', $restaurant)) {
            $food = $restaurant->foods()->create($request->all());
            return new FoodResource($food);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function update(Request $request, Restaurant $restaurant, $id)
    {
        try {
            $food = $restaurant->foods()->findOrFail($id);
            $food->update($request->all());
            return new FoodResource($food);
        } catch(ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function delete(Restaurant $restaurant, $id)
    {
        try {
            $food = $restaurant->foods()->findOrFail($id);
            $food->delete();
            return response()->json(['message' => 'food deleted']);
        } catch(ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }
}

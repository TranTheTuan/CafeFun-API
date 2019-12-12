<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Restaurant;
use App\Rating;
use App\Http\Resources\RatingResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RatingController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $ratings = $restaurant->ratings;
        return RatingResource::collection($ratings);
    }

    public function show(Restaurant $restaurant, $rating)
    {
        try {
            $ratings = $restaurant->ratings()->findOrFail($rating);
            return new RatingResource($ratings);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $data = $request->all();
        $rating = Rating::updateOrCreate([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurant->id], $data);
        $avg_rating = $restaurant->ratings()->pluck('point')->avg();
        $restaurant->update(['rating' => $avg_rating]);
        return new RatingResource($rating);
    }

    public function delete(Restaurant $restaurant, $rating)
    {
        if(Gate::allows('delete_rating', $rating)) {
            try {
                $rating = $restaurant->ratings()->findOrFail($rating);
                $rating->delete();
                return response()->json(['message' => 'deleted']);
            } catch (ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()]);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

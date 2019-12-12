<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\TableResource;
use Illuminate\Support\Facades\Gate;

class TableController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $tables = $restaurant->tables;
        return TableResource::collection($tables);
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        if(Gate::allows('manage', $restaurant)) {
            $table = $restaurant->tables()->create($request->all());
            return new TableResource($table);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function update(Request $request, Restaurant $restaurant, $table)
    {
        if(Gate::allows('manage', $restaurant)) {
            try {
                $table = $restaurant->tables()->findOrFail($table);
                $table->update($request->all());
                return new TableResource($table);
            } catch(ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()], 404);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function delete(Restaurant $restaurant, $table)
    {
        if(Gate::allows('manage', $restaurant)) {
            try {
                $table = $restaurant->tables()->findOrFail($table);
                $table->delete();
                return response()->json(['message' => 'table deleted']);
            } catch(ModelNotFoundException $exception) {
                return response()->json(['error' => $exception->getMessage()], 404);
            }
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

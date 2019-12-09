<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\TableResource;

class TableController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $tables = $restaurant->tables;
        return TableResource::collection($tables);
    }

    public function store(Request $request, Restaurant $restaurant)
    {
        $table = $restaurant->tables()->create($request->all());
        return new TableResource($table);
    }

    public function update(Request $request, Restaurant $restaurant, $id)
    {
        try {
            $table = $restaurant->tables()->findOrFail($id);
            $table->update($request->all());
            return new TableResource($table);
        } catch(ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }

    public function delete(Restaurant $restaurant, $id)
    {
        try {
            $table = $restaurant->tables()->findOrFail($id);
            $table->delete();
            return response()->json(['message' => 'table deleted']);
        } catch(ModelNotFoundException $exception) {
            return response()->json(['error' => $exception->getMessage()], 404);
        }
    }
}

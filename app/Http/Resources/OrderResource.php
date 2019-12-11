<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'table' => $this->table->number,
            'user' => new UserResource($this->user),
            'restaurant' => new RestaurantResource($this->restaurant),
            'foods' => FoodResource::collection($this->foods)
        ];
    }
}

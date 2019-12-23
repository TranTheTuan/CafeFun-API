<?php

namespace App\Services;

use Carbon\Carbon;
use App\Food;
use Illuminate\Support\Facades\DB;

class BestsellerService {
    public function get() {
        $now = Carbon::now();
        $lastweek = Carbon::now()->subDays(7);
        $bestseller = DB::table('food_order')->join('foods', 'foods.id', '=', 'food_order.food_id')
                                    ->selectRaw('food_order.food_id, foods.name, sum(food_order.number) as sum')
                                    ->whereBetween('food_order.created_at', [$lastweek, $now])
                                    ->groupBy('food_order.food_id')
                                    ->orderBy('sum', 'DESC')
                                    ->get();
        return $bestseller;
    }
}
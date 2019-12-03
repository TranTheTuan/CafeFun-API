<?php

use App\Address;
use App\Food;
use App\Restaurant;
use App\Table;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Restaurant::class, 5)->create()->each(function($restaurant) {
            factory(Address::class)->create(['restaurant_id' => $restaurant->id]);
            factory(Food::class, 5)->create(['restaurant_id' => $restaurant->id]);
            factory(Table::class, 5)->create(['restaurant_id' => $restaurant->id]);
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBestSellerColumnToFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->tinyInteger('best_seller')->default(0)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropColumn('best_seller');
        });
    }
}

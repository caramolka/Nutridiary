<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFooditemNutrientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fooditem_nutrient', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('fooditem_id');
            $table->unsignedInteger('nutrient_id');
            $table->double('per_100g');
            
            $table->foreign('fooditem_id')->references('id')->on('fooditems')->onDelete('cascade');
            $table->foreign('nutrient_id')->references('id')->on('nutrients')->onDelete('cascade');
                        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fooditem_nutrient');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutrientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutrients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255)->unique();
            $table->boolean('beneficial')->default(false);
            $table->boolean('basic')->default(false);
            $table->string('display_unit', 255)->default('g'); // kcal, g, mg, etc
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nutrients');
    }
}

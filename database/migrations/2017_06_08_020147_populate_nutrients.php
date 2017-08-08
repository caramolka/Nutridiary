<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Nutrient;

class PopulateNutrients extends Migration
{
 
    private $nutrients = array( 
    
        array(
                'name' => 'Calories',
                'beneficial' => false,
                'basic' => true,
                'display_unit' => 'kcal'
            ),
        array(
                'name' => 'Proteins',
                'beneficial' => true,
                'basic' => true,
                'display_unit' => 'g'
            ),
        array(
                'name' => 'Fat',
                'beneficial' => false,
                'basic' => true,
                'display_unit' => 'g'
            ),
        array(
                'name' => 'Carbohydrates',
                'beneficial' => false,
                'basic' => true,
                'display_unit' => 'g'
            ),
        array(
                'name' => 'Fiber',
                'beneficial' => true,
                'basic' => true,
                'display_unit' => 'g'
            ),
        array(
                'name' => 'Sodium',
                'beneficial' => false,
                'basic' => true,
                'display_unit' => 'mg'
            )
    );

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->nutrients as $n){
            $nutrientModel = new Nutrient;
            $nutrientModel->name = $n['name'];
            $nutrientModel->beneficial = $n['beneficial'];
            $nutrientModel->basic = $n['basic'];
            $nutrientModel->display_unit = $n['display_unit'];
            $nutrientModel->save();
        }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        foreach($this->nutrients as $n){
            App\Nutrient::where('name', $n['name'])->delete();
        }
    }
}

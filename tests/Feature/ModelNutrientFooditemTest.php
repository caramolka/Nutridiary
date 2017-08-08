<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;
use App\Nutrient;
use App\Fooditem;

class ModelNutrientFooditemTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNutrientModel()
    {
        $nutrient = new Nutrient;
        $nutrient->name = 'testNutrient';
        $nutrient->beneficial = true;
        $nutrient->save();
        
        Log::info('testNutrientModel(): nutrient->id = '. $nutrient->id);
        
        $newId = $nutrient->id;
        $nutrientNew = Nutrient::find($newId);
        $this->assertEquals($nutrientNew->name, $nutrient->name);
        $this->assertEquals($nutrientNew->beneficial, $nutrient->beneficial);
        
    }

    public function testFooditemNutrientRelation()
    {
        $nutrient1 = new Nutrient;
        $nutrient1->name = 'testNutrient1';
        $nutrient1->beneficial = true;
        $nutrient1->save();
        $nutrient1Id = $nutrient1->id;
        
        $nutrient2 = new Nutrient;
        $nutrient2->name = 'testNutrient2';
        $nutrient2->beneficial = true;
        $nutrient2->save();
        $nutrient2Id = $nutrient2->id;
        
        $nutrient3 = new Nutrient;
        $nutrient3->name = 'testNutrient3';
        $nutrient3->beneficial = false;
        $nutrient3->save();
        $nutrient3Id = $nutrient3->id;
        
        Log::info('testFooditemNutrientRelation(): nutrient1Id = '. $nutrient1Id);
        Log::info('testFooditemNutrientRelation(): nutrient2Id = '. $nutrient2Id);
        Log::info('testFooditemNutrientRelation(): nutrient3Id = '. $nutrient3Id);
        
        $fooditem = new Fooditem;
        $fooditem->name = 'testFooditem';
        $fooditem->save();
        $fooditem->nutrients()->attach([
            $nutrient1Id => ['per_100g' => 10],
            $nutrient2Id => ['per_100g' => 20],
            $nutrient3Id => ['per_100g' => 30]                                        
        ]);        
        $fooditemId = $fooditem->id;
        
        $fooditemNew = Fooditem::find($fooditemId) ;
        $this->assertEquals($fooditemNew->name, $fooditem->name);
        
        $allNutrients = $fooditemNew->nutrients()->orderBy('name')->get();
        
        Log::info('testFooditemNutrientRelation(): $allNutrients = '. $allNutrients);
        
        $this->assertEquals($allNutrients[0]->name, $nutrient1->name);
        $this->assertEquals($allNutrients[0]->pivot->per_100g, 10);
        $this->assertEquals($allNutrients[1]->name, $nutrient2->name);
        $this->assertEquals($allNutrients[1]->pivot->per_100g, 20);
        $this->assertEquals($allNutrients[2]->name, $nutrient3->name);
        $this->assertEquals($allNutrients[2]->pivot->per_100g, 30);
    }
}

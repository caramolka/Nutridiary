<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Log;

use App\User;
use App\Fooditem;
use App\Nutrient;

class FooditemTest extends TestCase
{
     use DatabaseMigrations;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        Log::info('FooditemTest.testCreate()');
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('fooditems/create');
        $response->assertStatus(200);
        
        $content = $response->getOriginalContent();
        $content = $content->getData();
        
        $returnedFooditem = $content['fooditem'];
        $returnedNutrients = $returnedFooditem->nutrients;
        $this->assertTrue((count($returnedNutrients) > 0), 'No nutrients in Fooditem');
        
        Log::info('FooditemTest.testShow(): $returnedFooditem = '.$returnedFooditem);
        Log::info('FooditemTest.testShow(): $returnedNutrients = '.$returnedNutrients);
        
        // Check the list of nutrients
        $correctNutrientNames = array(
            'Calories', 'Proteins', 'Fat', 'Carbohydrates', 'Fiber', 'Sodium' );
            
        $returnedNutrientNames = array();        
        foreach($returnedNutrients as $nutrient){
            $returnedNutrientNames[] =  $nutrient->name;
        }
        
        sort($correctNutrientNames);
        sort($returnedNutrientNames);
        $this->assertEquals($correctNutrientNames, $returnedNutrientNames);
        
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexNoItems()
    {
        Log::info('FooditemTest.testIndex()');
        $user = factory(User::class)->create();
        
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('fooditems');
        $response->assertStatus(200);
        
        $content = $response->getOriginalContent();
        $this->assertTrue(!is_null($content), 'Controller returned null content');
        $content = $content->getData();
        $this->assertTrue(array_key_exists('fooditems', $content));
        
        $returnedFooditems = $content['fooditems'];
        
        $this->assertTrue((count($returnedFooditems) == 0), 'No fooditems in DB but count > 0');
        
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexWithItems()
    {
        Log::info('FooditemTest.testIndex()');
        $user = factory(User::class)->create();
        
        $nutrients = array();
        $nct = 3;
        
        for($i = 0; $i < $nct; $i++){
            $nutrients[] = factory(Nutrient::class)->create([
                'name' => 'Nutrient' . ($i + 1)
            ]);
        }
        
        $fooditems = array();
        $fct = 4;
        
        for($i = 0; $i < $fct; $i++){
            $fooditems[] = factory(Fooditem::class)->create([
                'name' => 'Fooditem' . ($i + 1)
            ])->each(function($fooditem) use ($nutrients) {
                foreach($nutrients as $nutrient){
                    $fooditem->nutrients()->attach($nutrient, ['per_100g' => 33]);
                }
            });
        }
        
        
        
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('fooditems');
        $response->assertStatus(200);
        
        $content = $response->getOriginalContent();
        $this->assertTrue(!is_null($content), 'Controller returned null content');
        $content = $content->getData();
        $this->assertTrue(array_key_exists('fooditems', $content));
        
        $returnedFooditems = $content['fooditems'];
        
        $this->assertTrue((count($returnedFooditems) == $fct), 'No fooditems in DB but count > 0');
        
    }
   
    /**
    * Test for Show
    */
    public function testShow()
    {
        Log::info('FooditemTest.testShow()');
        $user = factory(User::class)->create();
        
        $fooditem = new Fooditem;
        $fooditem->name = 'testFooditem';
        $fooditem->serving_in_grams = 31;
        $fooditem->save();
        $fooditemId = $fooditem->id;
        
        $nutrients[1] = array( 'per_100g' => 300 );  
        $nutrients[2] = array( 'per_100g' => 2 ); 
        $nutrients[3] = array( 'per_100g' => 3 ); 
        $nutrients[4] = array( 'per_100g' => 4 ); 
        $nutrients[5] = array( 'per_100g' => 5 ); 
        $fooditem->nutrients()->attach($nutrients);
        
        Log::info('FooditemTest.testShow(): FooditemId = '.$fooditemId);
        
        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('fooditems/'.$fooditemId);
        $response->assertStatus(200);
        $response->assertViewHas('fooditem');
        $content = $response->getOriginalContent();
        $content = $content->getData();
        
        $returnedFooditem = $content['fooditem'];
        $returnedNutrients = $returnedFooditem->nutrients()->get();
        $this->assertTrue((count($returnedNutrients) > 0), 'No nutrients in Fooditem');
        
        Log::info('FooditemTest.testShow(): $returnedFooditem = '.$returnedFooditem);
        Log::info('FooditemTest.testShow(): $returnedNutrients = '.$returnedNutrients);
    }
}

<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Log;

use App\Nutrient;


class FooditemTest extends DuskTestCase
{
      use DatabaseMigrations;
   /**
     * A Dusk test example.
     *
     * @return void
     */
     
    
    //
    public function testIndexWithItems()
    {
        $user = factory(User::class)->create([
            'email' => 'testuser@example.com',
        ]);
    
        $this->browse(function (Browser $browser) use ($user) {
        
             
            
           $calories = Nutrient::where('name', 'Calories')->get();
            
            $browser->loginAs(User::find($user->id))
                    ->visit('fooditems')
                    ->assertSeeIn(('.button-link'), 'Add Fooditem')
                    ->click('#add-fooditem') // goto create
                    ->assertSee('Fooditem') 
                    ->type('name', 'FooditemTestItem')
                    ->type('serving_in_grams', '31')
                    ->type('nutrient-1-per_serving', '310')
                    ->type('nutrient-2-per_serving', '8')
                    ->type('nutrient-3-per_serving', '10')
                    ->type('nutrient-4-per_serving', '18')
                    ->type('nutrient-5-per_serving', '5')
                    ->type('nutrient-6-per_serving', '125')
                    ->press('Save') // goto show
                    ->assertSee('FooditemTestItem') 
                    ->assertSeeIn(('#nutrient-' . $calories[0]->id), 'Calories')
                    ->assertSeeIn(('#nutrient-' . $calories[0]->id), '1000')
                    ->click('#nav-fooditems') // goto fooditems
                    ->assertSee('FooditemTestItem'); 
            
        });
        
        $this->assertDatabaseHas('fooditems', ['name' => 'FooditemTestItem' ]);
        $this->assertDatabaseHas('fooditem_nutrient', 
            [   
                'per_100g' => 1000,
                'nutrient_id' => '1'
            ] 
        );
    }
    
}

<?php

namespace App\Http\Controllers;


use App\Fooditem;
use App\Nutrient;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Kumuwai\DataTransferObject\Laravel5DTO;

class FooditemController extends Controller
{
 
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');        
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nutrients = Nutrient::where('basic', true)->orderBy('id', 'asc')->get();
        $nutrientNames = [];
        foreach($nutrients as $nutrient){
            $nutrientNames[] = $nutrient->name;
        }
        
        $fooditems = Fooditem::get();
        $fooditemsDTO = [];
        
        foreach($fooditems as $fooditem){
            Log::info('FooditemController.index() fooditem: ' . print_r($fooditem->name, true));
           
            $fooditemNutrients = $fooditem->nutrients;
            
            //Log::info('FooditemController.index() fooditemNutrients: ' . print_r($fooditemNutrients, true));
            
            $fnp100g = [];
            $nnCnt = 0;
            foreach ($nutrientNames as $nn) {
            
                //Log::info('FooditemController.index() nutrientName: ' . print_r($nn, true));
   
                $fnp100g[$nnCnt] = '';
    
                foreach ($fooditemNutrients as $fooditemNutrient) {
                    Log::info('FooditemController.index() fooditemNutrient: ' . print_r($fooditemNutrient, true));
                   if ($fooditemNutrient->name == $nn) {
                        $fnp100g[$nnCnt] = $fooditemNutrient->pivot->per_100g;
                    }
                } // foreach.
                
                $nnCnt += 1;
                
            } // foreach.
            
            $fooditemsDTO[] = new Laravel5DTO([
                'id'=> $fooditem->id,
                'name' => $fooditem->name,
                'nutrients_per_100g' => $fnp100g
            ]);
        }
        
        //Log::info('FooditemController.index() fooditemsDTO: ' . print_r($fooditemsDTO, true));
       
        return view('fooditem.index', ['fooditems' => $fooditemsDTO, 'nutrients' => $nutrientNames]);
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::check()) {
            // The user is logged in...
            Log::info('FooditemController.create() 1');
            
            
            $basicNutrients = Nutrient::where('basic', true)->get();
            
            $nutrients = [];
            foreach($basicNutrients as $nutrient){
                $nutrients[$nutrient->id] = array(
                    'id' => $nutrient->id,
                    'name' => $nutrient->name,
                    'unit' => $nutrient->display_unit,
                    'per_100g' => ''
                );
            }
            
            $fooditemDTO = new Laravel5DTO([
                'name' => '',
                'serving_in_grams' => 100,
                'nutrients' => $nutrients
            ]);
            
            Log::info('FooditemController.create() 2');
            
            
            return view('fooditem.edit', ['fooditem' => $fooditemDTO]);
        }
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Log::info('FooditemController.store()');
        if (Auth::check()) {
            // The user is logged in...
            $fooditem = new Fooditem;
            $fooditem->name = $request->name;
            $fooditem->serving_in_grams = $request->serving_in_grams; 
            
            $fooditem->save();
            
            $nutrientIds = $request->input('nutrient_id');
             
            $per_100g = '';
            $nutrients = [];
            
            foreach($nutrientIds as $nutrientId){
                Log::info('FooditemController.store() $nutrientId = '.$nutrientId);
                $per_serving = 'nutrient-'.$nutrientId.'-per_serving';
                
                $per_100g = (float)$request->input($per_serving) / (float)$fooditem->serving_in_grams * 100 ;
                $nutrients[$nutrientId] = array( 'per_100g' => $per_100g );
            }
            //Log::info('FooditemController.store() $nutrients = '. print_r(array_keys($nutrients), true));
            $fooditem->nutrients()->attach($nutrients);
           
            return view('fooditem.show', ['fooditem' => $fooditem]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fooditem  $fooditem
     * @return \Illuminate\Http\Response
     */
    public function show(Fooditem $fooditem)
    {
        //
        Log::info('FooditemController.show()');
        if (Auth::check()) {
            // The user is logged in...
            return view('fooditem.show', ['fooditem' => $fooditem]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fooditem  $fooditem
     * @return \Illuminate\Http\Response
     */
    public function edit(Fooditem $fooditem)
    {
        //
        if (Auth::check()) {
            // The user is logged in...
            Log::info('FooditemController.edit() 1');
            
            
            //...
            
            Log::info('FooditemController.edit() 2');
            
            
            return view('fooditem.edit', ['fooditem' => $fooditemDTO]);
        }
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fooditem  $fooditem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fooditem $fooditem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fooditem  $fooditem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fooditem $fooditem)
    {
        //
    }
}

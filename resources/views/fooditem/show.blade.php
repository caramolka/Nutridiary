@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fooditem</div>

                <div class="panel-body">
                     
                    <div class="button-link" style="float: right;"><a href="/fooditems">Fooditems List</a></div>
                    <hr style="clear:both;" />
                   
                    <h1>{{$fooditem->name}}</h1>
                   
                    <div class="group-division">
                    
                        <div >Serving size: 100g</div>
                        <hr style="clear:both;" />
                    
                        @foreach ($fooditem->nutrients as $nutrient)
                            <div style="clear:both;" id="nutrient-{{$nutrient->id}}" >
                            
                                <div class="col-sm-2"></div>
                                <div class="col-sm-4">
                                    <strong>{{$nutrient->name}}</strong>
                                </div>
                                <div class="col-sm-4">
                                    {{round($nutrient->pivot->per_100g)}} {{$nutrient->display_unit}}
                                </div>
                                
                                <div class="col-sm-2"></div>
                           </div>
                        @endforeach
                        
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

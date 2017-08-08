@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fooditem List</div>

                <div class="panel-body">
                    
                    <h1>Fooditems</h1>
                    <div class="button-link" style="float: right;"><a href="/fooditems/create" id="add-fooditem">Add Fooditem</a></div>
                    <hr style="clear:both;" />
                    
                    <div class="group-division">
                        
                        <table>
                            <thead>
                                <th style="padding: 0 5px 0 0;">Fooditem Name</th>
                                
                                @foreach ($nutrients as $nutrient)
                                <th style="padding: 0 5px; border-left: rgba(0, 0, 0, 0.5) 1px solid;">{{$nutrient}}</th>
                                @endforeach
                                
                            </thead>
                            <tbody>
                                @foreach ($fooditems as $fooditem)
                                <tr>
                                    <td><a href="/fooditems/{{$fooditem->id}}">{{$fooditem->name}}</a></td>
                                    
                                    @foreach($fooditem->nutrients_per_100g as $np100g)
                                        <td>
                                        {{$np100g}}
                                        </td>
                                    @endforeach
                                    
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>                        
                        
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

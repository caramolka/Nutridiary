@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Fooditem</div>

                <div class="panel-body">
                    
                    <form
                        class="form-horizontal"
                        role="form"
                        method="POST"
                        action="{{
                            route( 'fooditems.store' )
                        }}"
                    >
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-4 control-label">Name</label>

                            <div class="col-sm-6">
                                <input 
                                    id="name"
                                    type="text"
                                    class="form-control" 
                                    name="name"
                                    value="{{ old('name', (isset($fooditem) ? $fooditem->name : '')) }}"
                                    required
                                    autofocus
                                >

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>              

                        <div class="form-group{{ $errors->has('serving_in_grams') ? ' has-error' : '' }}">
                            <label for="serving_in_grams" class="col-sm-4 control-label">Serving size (grams)</label>
                            

                            <div class="col-sm-6">
                                <input 
                                    id="serving_in_grams"
                                    type="number"
                                    class="form-control" 
                                    name="serving_in_grams"
                                    value="{{ old('serving_in_grams', (isset($fooditem) ? $fooditem->serving_in_grams : '100')) }}"
                                    required
                                    autofocus
                                >

                                @if ($errors->has('serving_in_grams'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serving_in_grams') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="group-division">
                        
                             <div >
                                <label  class="col-sm-4 control-label">Nutrient Name</label>
                                <label  class="col-sm-6 control-label">Per 100g</label>
                                <label  class="col-sm-1 control-label">Unit</label>
                            </div>
                            <hr style="clear:both;" />
                        
                            @foreach ($fooditem->nutrients as $nutrient)
                                 <div class="form-group{{ $errors->has('nutrient-' . $nutrient->id) ? ' has-error' : '' }}">
                                    <label for="nutrient-{{$nutrient->id}}" class="col-sm-4 control-label">{{$nutrient->name}}</label>
                                    <input type="hidden" name="nutrient_id[]" value="{{$nutrient->id}}">

                                    <div class="col-sm-6">
                                        <input 
                                            id="nutrient-{{$nutrient->id}}-per_serving"
                                            type="number"
                                            class="form-control" 
                                            name="nutrient-{{$nutrient->id}}-per_serving"
                                            value="{{ old('nutrient-' . $nutrient->id . '-per_serving') }}"
                                            required
                                            autofocus
                                        >                                        
                                    </div>
                                    
                                    <div class="col-sm-1">
                                         {{$nutrient->unit}}                                       
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                        
                        
                        

                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

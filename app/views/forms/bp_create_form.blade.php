@extends('layouts.adminmaster')
 
{{-- main.prepend --}}
@section('main.prepend')
{{-- maybe, need dump form errors --}}
<div class="row">
@stop
 

{{-- content --}}
@section('content')
@if ( $errors->count() > 0 )
    <div class="alert alert-error alert-danger col-md-6 col-md-offset-3">
        <h4 class="text-center">The following errors have occurred:</h4>
        <ul>
            @foreach( $errors->all() as $message )
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if ( Session::get('notice') )
                    <div class="text-center alert alert-success col-md-6 col-md-offset-3">{{ Session::get('notice') }}</div>
@endif
<div class="col-md-12">
    <!--<h2 class="text-center">Register a Business Partner</h2>-->
    <div class="col-md-12">
        <form class="form-inline" role="form" method="POST" action="{{{ action('BusinessPartnerController@save') }}}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <fieldset>
                <div>
                     <label class="dst_form_label control-label">BP Contact Info</label>
                </div>
                <div class="form-group col-md-12">
                    <div class="col-md-4">
                        <label for="bp_name" class="control-label">{{{ Lang::get('strings.bp_bus_name') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_bus_name') }}}" type="text" name="bp_name" id="bp_loc_building" value="{{{ Input::old('bp_name') }}}"> 
                    
                    </div>
                    <div class="col-md-4">
                        <label for="bp_contact_fname">{{{ Lang::get('strings.bp_contact_fname') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_contact_fname') }}}" type="text" name="bp_contact_fname" id="bp_contact_fname" value="{{{ Input::old('bp_contact_fname') }}}">
                    </div>
                    <div class="col-md-4">
                        <label for="bp_contact_lname">{{{ Lang::get('strings.bp_contact_lname') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_contact_lname') }}}" type="text" name="bp_contact_lname" id="bp_contact_lname" value="{{{ Input::old('bp_contact_lname') }}}">
                    </div>
                </div>
                
                <div>
                    <label class="dst_form_label control-label">Address</label>
                </div>
                    <div class="form-group col-md-12" id="bp_loc">
                        
                    <div class="col-md-3">
                        <label for="bp_building" class="control-label">{{{ Lang::get('strings.bp_building') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_building') }}}" type="text" name="bp_loc_building" id="bp_loc_building" value="{{{ Input::old('bp_loc_building') }}}">
                    </div>
                    <div class="col-md-3">
                        <label for="bp_street">{{{ Lang::get('strings.bp_street') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_street') }}}" type="text" name="bp_loc_street" id="bp_loc_street" value="{{{ Input::old('bp_loc_street') }}}">
                    </div>
                    <div class="col-md-3">
                        <label for="bp_city">{{{ Lang::get('strings.bp_city') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_city') }}}" type="text" name="bp_loc_city" id="bp_loc_city" value="{{{ Input::old('bp_loc_city') }}}">
                    </div>
                    <div class="col-md-3">
                        <label for="bp_country">{{{ Lang::get('strings.bp_country') }}}</label>
                        <input class="form-control" placeholder="{{{ Lang::get('strings.bp_country') }}}" type="text" name="bp_loc_country" id="bp_loc_country" value="{{{ Input::old('bp_loc_country') }}}">
                    </div>
                    
                    </div>
                
               
                <div class="form-actions col-md-6 col-md-offset-3 row">
                  <button type="submit" class="btn btn-primary btn-block">{{{ Lang::get('strings.bp_submit') }}}</button>
                </div>

            </fieldset>
        </form>
    </div>
    
</div>
 
               
@stop
 

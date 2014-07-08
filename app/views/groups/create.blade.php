@extends('layouts.adminmaster')

@section('content')
<div class="col-md-6 col-md-offset-3">
    <h2 class="text-center">Create New Group</h2>
    <div>
    
        <form class="form-horizontal" role="form" method="POST" action="{{{ action('GroupController@save') }}}" accept-charset="UTF-8">
            <fieldset>
                <div class="form-group">
                    <label for="group_name">{{{ Lang::get('strings.role_name') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.role_name') }}}" type="text" name="group_name" id="group_name" value="{{{ Input::old('group_name') }}}">
                </div>
                <div class="form-group">
                    <label for="group_desc">{{{ Lang::get('strings.role_description') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.role_description') }}}" type="text" name="mname" id="mname" value="{{{ Input::old('group_desc') }}}">
                </div>
                <div class="form-group">
                    <label for="permissions[]">Permission(s)</label>
                    <select name="permissions[]" id="permissions[]" class="multiselect form-control" multiple="multiple">
                         @foreach($permissions as $permission)
                            <option value="{{{$permission['id']}}}">{{$permission['display_name']}}</option>  
                         @endforeach
                    </select>
                   
                </div>
                @if ( Session::get('error') )
                    <div class="alert alert-error alert-danger">
                        @if ( is_array(Session::get('error')) )
                            {{ head(Session::get('error')) }}
                        @endif
                    </div>
                @endif

                @if ( Session::get('notice') )
                    <div class="alert">{{ Session::get('notice') }}</div>
                @endif

                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-block">{{{ Lang::get('strings.group_submit') }}}</button>
                </div>
            </fieldset>
        </form>
       </div>
</div>
@stop

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-multiselect.css')}}" type="text/css"/>
@stop

@section('scripts')
     <script src="{{ URL::asset('js/bootstrap-multiselect.js')}}"></script>
     
     <script type="text/javascript">
        $(document).ready(function() {
            $('.multiselect').multiselect({
                buttonWidth: '300px'
            });
        });
     </script>
@stop
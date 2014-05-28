@extends('layouts.publicmaster')

@section('content')
<div class="panel panel-default col-md-6 col-md-offset-3">
    <h2 class="text-center">Create New Group</h2>
    <div class="panel-body">
    
        <form class="form-horizontal" role="form" method="POST" action="{{{ action('GroupController@save') }}}" accept-charset="UTF-8">
            <fieldset>
                <div class="form-group">
                    <label for="group_name">{{{ Lang::get('strings.role_name') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.role_name') }}}" type="text" name="group_name" id="group_name" value="{{{ Input::old('fname') }}}">
                </div>
                <div class="form-group">
                    <label for="group_desc">{{{ Lang::get('strings.role_description') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.role_description') }}}" type="text" name="mname" id="mname" value="{{{ Input::old('mname') }}}">
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

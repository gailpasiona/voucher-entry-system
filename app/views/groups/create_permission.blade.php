@extends('layouts.publicmaster')

@section('content')
<div class="panel panel-default col-md-6 col-md-offset-3">
    <h2 class="text-center">Create New Permission</h2>
    <div class="panel-body">
    
        <form class="form-horizontal" role="form" method="POST" action="{{{ action('BusinessPartnerController@save') }}}" accept-charset="UTF-8">
            <fieldset>
                <div class="form-group">
                    <label for="perm_name">{{{ Lang::get('strings.perm_name') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.perm_name') }}}" type="text" name="perm_name" id="perm_name" value="{{{ Input::old('perm_name') }}}">
                </div>
                <div class="form-group">
                    <label for="perm_dispname">{{{ Lang::get('strings.perm_dispname') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('strings.perm_dispname') }}}" type="text" name="perm_dispname" id="perm_dispname" value="{{{ Input::old('perm_dispname') }}}">
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
                    <button type="submit" class="btn btn-primary btn-block">{{{ Lang::get('strings.perm_submit') }}}</button>
                </div>
            </fieldset>
        </form>
       </div>
</div>
@stop

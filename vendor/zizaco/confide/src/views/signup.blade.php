@extends('layouts.publicmaster')
 
{{-- main.prepend --}}
@section('main.prepend')
{{-- maybe, need dump form errors --}}
<div class="row">
@stop
 

{{-- content --}}
@section('content')

<div class="panel panel-default col-md-6 col-md-offset-3">
    <h2 class="text-center">User Registration</h2>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{{ (Confide::checkAction('UserController@store')) ?: URL::to('user')  }}}" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
            <fieldset>
                <div class="form-group">
                    <label for="fname">{{{ Lang::get('confide::confide.fname') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.fname') }}}" type="text" name="fname" id="fname" value="{{{ Input::old('fname') }}}">
                </div>
                <div class="form-group">
                    <label for="mname">{{{ Lang::get('confide::confide.mname') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.mname') }}}" type="text" name="mname" id="mname" value="{{{ Input::old('mname') }}}">
                </div>

                <div class="form-group">
                    <label for="lname">{{{ Lang::get('confide::confide.lname') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.lname') }}}" type="text" name="lname" id="lname" value="{{{ Input::old('lname') }}}">
                </div>

                <div class="form-group">
                    <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
                </div>
                <div class="form-group">
                    <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <small>{{ Lang::get('confide::confide.signup.confirmation_required') }}</small></label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
                </div>
                <div class="form-group">
                    <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
                    <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
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
                  <button type="submit" class="btn btn-primary btn-block">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
                </div>

            </fieldset>
        </form>
    </div>
</div>

@stop
 

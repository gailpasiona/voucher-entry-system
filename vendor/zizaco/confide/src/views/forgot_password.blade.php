@extends('layouts.publicmaster')
@section('content')
<div class="col-md-6 col-md-offset-3">
    <h3 class="text-center">Reset Your Password</h3>
    <form method="POST" action="{{ (Confide::checkAction('UserController@do_forgot_password')) ?: URL::to('/user/forgot') }}" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">

        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>
        <div class="form-actions form-group">
                  <button type="submit" class="btn btn-primary btn-block">{{{ Lang::get('confide::confide.forgot.submit') }}}</button>
        </div>

        @if ( Session::get('error') )
            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if ( Session::get('notice') )
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
    </form>
</div>
@stop

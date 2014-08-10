@extends('layouts.adminmaster')

@section('content')

<div class="col-md-6 col-md-offset-3">
    <h2 class="text-center">User Assignment</h2>
    
    <div>
        <form class="form-horizontal" role="form" method="POST" action="{{{ action('GroupController@update_user_role') }}}" accept-charset="UTF-8">
            <fieldset>
                <div class="form-group">
                    <label for="group_name">{{{ Lang::get('strings.role_name') }}}</label>
                    <select name="user" id="user" class="form-control">
                         @foreach($users as $user)
                            <option value="{{{$user['id']}}}">{{$user['username']}}</option>  
                         @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="prole">Role</label>
                    <select name="role" id="role" class="form-control">
                         @foreach($roles as $role)
                            <option value="{{{$role['id']}}}">{{$role['name']}}</option>  
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
<!--                    <div class="alert">{{ Session::get('notice') }}</div>-->
                        <div class="alert">{{ $notice}}</div>
                @endif

                <div class="form-actions form-group">
                    <button type="submit" class="btn btn-primary btn-block">Assign User Role</button>
                </div>
            </fieldset>
        </form>
    </div>

</div>

@stop

<!--@section('styles')
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
@stop-->
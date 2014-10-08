<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<title>@yield('title', 'default title')</title>
 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width">
@yield('meta')
 
<!-- stylesheets -->
{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css') }}
{{HTML::style('font-awesome/css/font-awesome.css')}}
<!--{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css') }}-->
<!--{{HTML::style('//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css')}}-->
{{ HTML::style('//cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.css')}}

@yield('styles')
{{ HTML::style('css/app.css') }}
{{ HTML::style('css/forms.css')}}
{{HTML::style("css/plugins/morris/morris-0.4.3.min.css")}}
{{HTML::style("css/plugins/timeline/timeline.css")}}
<!--{{HTML::style("css/sb-admin.css")}}-->
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js') }}
<script>
var URL = {
'base' : '{{ URL::to('/') }}',
'current' : '{{ URL::current() }}',
'full' : '{{ URL::full() }}'
};
</script>
</head>

<body>

<div id="wrapper">
   <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">DSTI Voucher Entry Dev</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
<!--                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        
                       
                    </ul>
                     /.dropdown-messages 
                </li>
                 /.dropdown 
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        
                    </ul>
                     /.dropdown-tasks 
                </li>
                 /.dropdown 
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        
                    </ul>
                     /.dropdown-alerts 
                </li>-->
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{{ action('UserController@logout') }}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
<!--                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">S
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                                
                            </span>
                            </div>
                             /input-group 
                        </li>-->
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
<!--                        <li>
                            <a href="{{{action('VoucherController@edit')}}}"><i class="fa fa-list fa-fw"></i> Voucher</a>
                        </li>-->
                        <li>
                            <a href="#"><i class="fa fa-list fa-fw"></i> Vouchers<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{{action('VoucherController@edit')}}}">Create / Update</a>
                                </li>
                                <li>
                                    <a href="{{{action('VoucherController@reporting')}}}">Reports</a>
                                </li>
                            </ul>
                             <!--.nav-second-level--> 
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> Setup<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
<!--                                <li>
                                    <a href="#">Users <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{{action('UserController@create')}}}">Create User</a>
                                        </li>
                                        <li>
                                            <a href="">Modify User</a>
                                        </li>
                                        <li>
                                            <a href="">Suspend User</a>
                                        </li>
                                    </ul>
                                     /.nav-third-level 
                                </li>-->
                                <li>
<!--                                    <a href="#">Business Partners <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">-->
                                        <li>
                                            <a href="{{{action('BusinessPartnerController@listrecords')}}}"> Business Partner</a>
                                        </li>
<!--                                        <li>
                                            <a href="">Modify Business Partner</a>
                                        </li>
                                    </ul>-->
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
                                    <a href="#">Authorization <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="{{{action('GroupController@create')}}}">Roles</a>
                                        </li>
<!--                                        <li>
                                            <a href="">Modify a Role</a>
                                        </li>
-->                                        <li>
                                            <a href="{{{action('GroupController@attach_user')}}}">Assign User(s) to Role</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                                <li>
<!--                                    <a href="#">Permission <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">-->
                                        <li>
                                            <a href="{{{action('PermissionController@create')}}}">Permissions</a>
                                        </li>
<!--                                        <li>
                                            <a href="#">Modify a Permission</a>
                                        </li>
                                        <li>
                                            <a href="#">Delete permission</a>
                                        </li>
                                    </ul>-->
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
   </nav>
    <div id="page-wrapper">
        <div id="content">
            @yield('content')
            @yield('modal_edit')
        </div><!-- ./ #content -->
    </div>
</div><!-- ./ #main -->
 
 
 
<!-- scripts 
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js') }}
<!--{{ HTML::script('//cdn.datatables.net/1.10.0/js/jquery.dataTables.js') }}-->
<!--{{ HTML::script('//cdn.datatables.net/plug-ins/28e7751dbec/integration/bootstrap/3/dataTables.bootstrap.js')}}-->
<script src="{{ URL::asset('//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js')}}"></script>
<script src="{{ URL::asset('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js')}}"></script> 
<script src="{{ URL::asset('js/jquery.dataTables.js')}}"></script> 
<script src="{{ URL::asset('js/dataTables.bootstrap.js')}}"></script>
<script src="{{ URL::asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ URL::asset('js/sb-admin.js')}}"
<script src="{{ URL::asset('js/bootstrap-multiselect.js')}}"></script>

    
    
   
@yield('scripts')

<script src="{{ URL::asset('js/items.js')}}"></script> 
 
<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src='//www.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
 
</body>
</html>


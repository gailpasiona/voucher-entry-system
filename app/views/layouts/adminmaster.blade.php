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
{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css') }}
{{ HTML::style('//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js')}}
@yield('styles')
{{ HTML::style('css/app.css') }}
 
 
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js') }}
<script>
var URL = {
'base' : '{{ URL::to('/') }}',
'current' : '{{ URL::current() }}',
'full' : '{{ URL::full() }}'
};
</script>
</head>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-inner">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Voucher Entry</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Create a User</a></li>
                  <li><a href="#">Modify a User</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Suspend a User</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Group <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Create a Group</a></li>
                  <li><a href="#">Modify a Group</a></li>
                  <li><a href="#">Delete a Group</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Group Permissions</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav pull-right">
              <li><a href="#"></a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Me <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Profile</a></li>
                  <li><a href="#">Change Password</a></li>
                  <li class="divider"></li>
                  <li><a href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </div>
</nav> 
<body>

<div id="main">
<div class="container">
 
<!--@yield('main.prepend')-->
 
<div id="content">
@yield('content')
</div><!-- ./ #content -->
 

 
</div>
</div><!-- ./ #main -->
 
 
 
<!-- scripts -->
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js') }}
@yield('scripts')
{{ HTML::script('public/js/app.js') }}
 
<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
g.src='//www.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
 
</body>
</html>


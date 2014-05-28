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
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account<b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="{{{ (Confide::checkAction('UserController@login')) ?: 'login' }}}">Sign In</a></li>
            <li><a href="{{{ (Confide::checkAction('UserController@create')) ?: 'create' }}}">Sign Up</a></li>
            <li class="divider"></li>
            <li><a href="{{{ (Confide::checkAction('UserController@forgot_password')) ?: 'forgot' }}}">Forgot Password</a></li>
          </ul>
        </li>
      </ul>
     
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
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

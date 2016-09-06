<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title') | Backend</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="/css/backend.css">

  <link rel="shortcut icon" href="favicon.ico">

  <style>
    body {
      font-family: "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
    }

    h1,h2,h3,h4,h5 {
      font-family: "Microsoft YaHei", "WenQuanYi Micro Hei", sans-serif;
    }

    .edui-scale {
      box-sizing: content-box;
    }

    .sidebar-menu li>a>.pull-right {
      transition-duration: 500ms;
    }
  </style>

  @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

  <body class="hold-transition sidebar-mini skin-blue-light fixed">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="{{url('/backend')}}" class="logo hidden-xs">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Backend</span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            @if (Auth::guest())

            @else
             <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/image/test.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"> 用户名 </span>
              </a>
              <ul class="dropdown-menu" style="width: inherit;min-width: inherit">
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat">登出</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
            @endif
          </ul>
        </div>
      </nav>
    </header>

    @if (Auth::guest())
    @else
      @include('backend.layouts.aside')
    @endif
    @yield('content')

    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 0.0.1
      </div>
      <strong>Laravel-boilerplate<a href="#"></a></strong>
    </footer>


      @if (Auth::guest())

      @else
        @include('backend.layouts.control-aside')
      @endif
    <div class="control-sidebar-bg"></div>
  </div><!-- ./wrapper -->

  <script src="/js/backend.js"></script>


  @yield('js')
  </body>
</html>
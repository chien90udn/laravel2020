<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->

<!--Styles-->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/styles.css') }}">
  <![endif]-->
    <!-- Google Font -->
    @include('scripts.ajax-route')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ URL::asset('assets/admin/js/script.js') }}" type="text/javascript"></script>
    <!--Select picker-->
    <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ route('admin.index') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>P</b>Tom</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>PhanTom</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
{{--                        <li class="dropdown messages-menu">--}}
{{--                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                                <i class="fa fa-envelope-o"></i>--}}
{{--                                <span class="label label-success">4</span>--}}
{{--                            </a>--}}
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li class="header">You have 4 messages</li>--}}
{{--                                <li>--}}
{{--                                    <!-- inner menu: contains the actual data -->--}}
{{--                                    <ul class="menu">--}}
{{--                                        <li>--}}
{{--                                            <!-- start message -->--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <img src="{{ URL::asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <h4>--}}
{{--                                                    Support Team--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>--}}
{{--                                                </h4>--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <!-- end message -->--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <img src="{{ URL::asset('assets/admin/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <h4>--}}
{{--                                                    AdminLTE Design Teamdropdown-toggle--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>--}}
{{--                                                </h4>--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <img src="{{ URL::asset('assets/admin/dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <h4>--}}
{{--                                                    Developers--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> Today</small>--}}
{{--                                                </h4>--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <img src="{{ URL::asset('assets/admin/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <h4>--}}
{{--                                                    Sales Department--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>--}}
{{--                                                </h4>--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <div class="pull-left">--}}
{{--                                                    <img src="{{ URL::asset('assets/admin/dist/img/user4-128x128.jpg') }}" class="img-circle" alt="User Image">--}}
{{--                                                </div>--}}
{{--                                                <h4>--}}
{{--                                                    Reviewers--}}
{{--                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>--}}
{{--                                                </h4>--}}
{{--                                                <p>Why not buy a new awesome theme?</p>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li class="footer"><a href="#">See All Messages</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                        <!-- User Account: style can be found in dropdown.less -->
                        @if(!Auth::guard('admin')->check())
                            <li class="dropdown user user-menu">
                                <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                            </li>
                        @else
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span>{{ Auth::guard('admin')->user()->name }}</span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <a href="{{ route("admin.profile") }}" class="btn btn-default btn-flat"> Profile</a>
                                    </li>
                                    <li class="user-footer">
                                        <a  href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat"> {{ __('Logout') }}</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest

                    </ul>
                </div>
            </nav>
        </header>

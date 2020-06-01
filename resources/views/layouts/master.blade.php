<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="{{ app()->getLocale() }}">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <title> {{$title}} | Money Transfer Admin</title>
        <meta content="Preview page of Metronic Admin Theme #3 for statistics, charts, recent events and reports" name="description" />
        <meta content="" name="author" />
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="Ullah" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{URL::asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{URL::asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_componen" type="text/css" />
        <link href="{{URL::asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->

        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{URL::asset('assets/layouts/layout3/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/layouts/layout3/css/themes/default.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{URL::asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{URL::asset('assets/layouts/layout3/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->

        <link rel="shortcut icon" href="{{URL::asset('favicon.ico')}}" />
    </head>
    <!-- END HEAD -->
    <body class="page-container-bg-solid">
        <div class="page-wrapper">
            <div class="page-wrapper">

                <div class="page-wrapper-row">
                    <div class="page-wrapper-top">
                        <!-- BEGIN HEADER -->
                        <div class="page-header">
                            <!-- BEGIN HEADER TOP -->
                            <div class="page-header-top">
                                <div class="container">
                                    <!-- BEGIN LOGO -->
                                    <div class="page-logo"  style="padding-bottom: 10px;" >
                                        <a href="{{URL::to('/')}}"> <img
                                                src="{{URL::to('/assets/layouts/layout3/img/recommend-logo.png')}}" alt="logo"
                                                style="width:auto; height: 45px; margin-top: 15px;"
                                                class="logo-default"><br>
                                        </a>
                                        <br>
                                    </div>
                                    <!-- END LOGO -->
                                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                    <a href="javascript:;" class="menu-toggler"></a>
                                    <!-- END RESPONSIVE MENU TOGGLER -->
                                    <!-- BEGIN TOP NAVIGATION MENU -->
                                    <div class="top-menu">
                                        <ul class="nav navbar-nav pull-right">
                                            <li class="dropdown dropdown-user dropdown-dark"><a
                                                    href="javascript:;" class="dropdown-toggle"
                                                    data-toggle="dropdown" data-hover="dropdown"
                                                    data-close-others="true"> 
                                                    <img alt="IMG" class="img-circle profile_img"
                                                        @if(Auth::user()->profile_pic)
                                                            src="{{URL::to('/')}}{{ Auth::user()->profile_pic}}"
                                                        @else 
                                                             src="/assets/pages/media/profile/avatar.png" 
                                                        @endif
                                                        > <span
                                                         class="username username-hide-mobile">
                                                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                                    </span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-default">
                                                    <li><a href="{{ route('profile') }}"> <i class="icon-user"></i> My
                                                            Profile
                                                        </a></li>

                                                    <li><a href="{{ route('lockscreen') }}"> <i class="icon-lock"></i> Lock
                                                            Screen
                                                        </a></li>
                                                    <li><a href="{{ route('logout') }}"> <i class="icon-key"></i> Log Out
                                                        </a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END TOP NAVIGATION MENU -->
                                </div>
                            </div>
                            <!-- END HEADER TOP -->
                            <!-- BEGIN HEADER MENU -->
                            <div class="page-header-menu">
                                <div class="container">
                                    <!-- BEGIN HEADER SEARCH BOX -->
                                    <form class="search-form" action="page_general_search.html"
                                          method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search"
                                                   name="query"> <span class="input-group-btn"> <a
                                                    href="javascript:;" class="btn submit"> <i
                                                        class="icon-magnifier"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </form>
                                    <!-- END HEADER SEARCH BOX -->
                                    <!-- BEGIN MEGA MENU -->
                                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                                    <div class="hor-menu  ">
                                        <ul class="nav navbar-nav">
                                            <li aria-haspopup="true"
                                                class="menu-dropdown classic-menu-dropdown active"><a
                                                    href="{{ route('/') }}"> Dashboard <span class="arrow"></span>
                                                </a>
                                            </li>
                                            <li aria-haspopup="true"
                                                class="menu-dropdown classic-menu-dropdown "><a
                                                    href="javascript:;"> Transection <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-left">
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/transection-initial')}}" class="nav-link nav-toggle "> <i
                                                                class="icon-settings"></i> Request <span class="arrow"></span>
                                                        </a></li>
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/transection-waiting')}}" class="nav-link nav-toggle "> <i
                                                                class="icon-settings"></i> Waiting <span class="arrow"></span>
                                                        </a></li>
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/transection-completed')}}" class="nav-link nav-toggle ">
                                                            <i class="icon-bar-chart"></i> Completed <span class="arrow"></span>
                                                        </a></li>
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/transection-daily')}}" class="nav-link nav-toggle ">
                                                            <i class="icon-bar-chart"></i> Daily Transection <span class="arrow"></span>
                                                        </a></li>
                                                         <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/transection-failed')}}" class="nav-link nav-toggle ">
                                                            <i class="icon-bar-chart"></i> Failed Transection <span class="arrow"></span>
                                                        </a></li>                                                        
                                                </ul></li>

                                            <li aria-haspopup="true"
                                                class="menu-dropdown classic-menu-dropdown "><a
                                                    href="javascript:;"> Customer <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-left">
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/customer-list')}}" class="nav-link nav-toggle "> <i
                                                                class="icon-settings"></i> Customer List <span class="arrow"></span>
                                                        </a></li>
                                                </ul></li>
                                            
                                                <li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown">
                                                    <a href="{{ route('exchange-rate') }}"> Exchange Rate <span class="arrow"></span></a>
                                            </li>
                                            @if(Auth::user()->level == 1)
                                            <li aria-haspopup="true"
                                                class="menu-dropdown classic-menu-dropdown "><a
                                                    href="javascript:;"> <i class="icon-user"></i> User <span class="arrow"></span>
                                                </a>
                                                <ul class="dropdown-menu pull-left">
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/new-user')}}" class="nav-link nav-toggle "> <i
                                                                class="icon-settings"></i> Add New User <span class="arrow"></span>
                                                        </a></li>
                                                    <li aria-haspopup="true" class="dropdown-submenu "><a
                                                            href="{{URL::to('/users')}}" class="nav-link nav-toggle "> <i
                                                                class="icon-settings"></i> Users <span class="arrow"></span>
                                                        </a></li>
                                                </ul>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <!-- END MEGA MENU -->
                                </div>
                            </div>
                            <!-- END HEADER MENU -->
                        </div>
                        <!-- END HEADER -->
                    </div>
                </div>

                <div class="page-wrapper-row full-height">
                    <div class="page-wrapper-middle">
                        <!-- BEGIN CONTAINER -->
                        <div class="page-container">
                            <!-- BEGIN CONTENT -->
                            <div class="page-content-wrapper">
                                <!-- BEGIN CONTENT BODY -->
                                <!-- BEGIN PAGE HEAD-->
                                <!-- BEGIN PAGE HEAD-->
                                <div class="page-head">
                                    <div class="container">
                                        <!-- BEGIN PAGE TITLE -->
                                        <div class="page-title">
                                            <h1> {{$title}} </h1>
                                        </div>
                                        <!-- END PAGE TITLE -->
                                        <!-- BEGIN PAGE TOOLBAR -->
                                        <div class="page-toolbar">
                                            <!-- BEGIN THEME PANEL -->
                                            <div class="btn-group btn-theme-panel">
                                                <!--                                                <a href="javascript:;" class="btn dropdown-toggle"
                                                                                                   data-toggle="dropdown"> <i class="icon-settings"></i>
                                                                                                </a>-->
                                            </div>
                                            <!-- END THEME PANEL -->
                                        </div>
                                        <!-- END PAGE TOOLBAR -->
                                    </div>
                                </div>
                                <!-- END PAGE HEAD-->

                                <!-- END PAGE HEAD-->
                                <!-- BEGIN PAGE CONTENT BODY -->
                                <div class="page-content">
                                    <div class="container">
                                        <!-- BEGIN PAGE BREADCRUMBS -->
                                        <ul class="page-breadcrumb breadcrumb">
                                            <li><a href="index.php">Home</a> <i class="fa fa-circle"></i></li>
                                            <li><span>{{$title}}</span></li>
                                        </ul>
                                        <!-- END PAGE BREADCRUMBS -->
                                        <!-- BEGIN PAGE CONTENT INNER -->
                                        <div class="page-content-inner">
                                            @yield('content')
                                        </div>
                                        <!-- END PAGE CONTENT INNER -->
                                    </div>
                                </div>
                                <!-- END PAGE CONTENT BODY -->
                                <!-- END CONTENT BODY -->
                            </div>
                            <!-- END CONTENT -->
                        </div>
                        <!-- END CONTAINER -->
                    </div>
                </div>

                <div class="page-wrapper-row">
                    <div class="page-wrapper-bottom">
                        <!-- BEGIN FOOTER -->
                        <!-- BEGIN PRE-FOOTER -->
<!--                        <div class="page-prefooter">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12 footer-block">
                                        <h2>About</h2>
                                        <p>Himilo AB work for the all forener living in Sweden</p>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 footer-block">
                                        <h2>Follow Us On</h2>
                                        <ul class="social-icons">
                                            <li><a href="javascript:;" data-original-title="rss" class="rss"></a></li>
                                            <li><a href="javascript:;" data-original-title="facebook"
                                                   class="facebook"></a></li>
                                            <li><a href="javascript:;" data-original-title="twitter"
                                                   class="twitter"></a></li>
                                            <li><a href="javascript:;" data-original-title="googleplus"
                                                   class="googleplus"></a></li>
                                            <li><a href="javascript:;" data-original-title="linkedin"
                                                   class="linkedin"></a></li>
                                            <li><a href="javascript:;" data-original-title="youtube"
                                                   class="youtube"></a></li>
                                            <li><a href="javascript:;" data-original-title="vimeo"
                                                   class="vimeo"></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 footer-block">
                                        <h2>Contacts</h2>
                                        <address class="margin-bottom-40">
                                            Phone: 46(0) 730 449 308<br> Email: <a
                                                href="mailto:info@himilo.se">info@himilo.se</a>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <!-- END PRE-FOOTER -->
                        <!-- BEGIN INNER FOOTER -->
                        <div class="page-footer">
                            <div class="container">
                                2017 &copy; &nbsp; <a target="_blank" href="http://swebd.se">Swebd
                                    Innovation</a> &nbsp;
                            </div>
                        </div>
                        <div class="scroll-to-top">
                            <i class="icon-arrow-up"></i>
                        </div>
                        <!-- END INNER FOOTER -->
                        <!-- END FOOTER -->

                        <div id="message">
                            <div class="alert fade in alert-dismissable" style="margin-top:18px;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <span><strong>Success!</strong> This alert box indicates a successful or positive action.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{URL::asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{URL::asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>      
        <script src="{{URL::asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>

        <script src="{{URL::asset('assets/pages/scripts/table-datatables-buttons.js')}}" type="text/javascript"></script>


        <script src="{{URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/pie.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/radar.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/themes/patterns.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amcharts/themes/chalk.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/ammap/ammap.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/ammap/maps/js/worldLow.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/amcharts/amstockcharts/amstock.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/horizontal-timeline/horizontal-timeline.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->

        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{URL::asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->

        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{URL::asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{URL::asset('assets/layouts/layout3/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/layouts/layout3/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <script src="{{URL::asset('assets/apps/scripts/site.js')}}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

    </body>
</html>
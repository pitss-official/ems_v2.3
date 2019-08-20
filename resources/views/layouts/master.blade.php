<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Event Management System for Organizations which facilitates easy management, online enrollments, ticket booking, online payments and much more">
    <meta name="author" content="Nukrip Technologies Private Limited">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="512x512" href="/logo.png">
    <title>{{ config('app.name', 'EMS') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="/assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <!-- Vector CSS -->
    <link href="/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link href="/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="/css/colors/{{Auth::user()->lastTheme()}}.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
{{--    PWA STUFF--}}
    <link rel="manifest" href="/app/app.json">
    <link rel="manifest" href="/app/app.webmanifest">
    <!-- icon in the highest resolution we need it for -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="512x512" href="/icon.png">
    <!-- reuse same icon for Safari -->
    <link rel="apple-touch-icon" href="/icon.png">
    <link rel="apple-touch-startup-image" href="/icon.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="blue">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- multiple icons for IE -->
    <meta name="msapplication-square310x310logo" content=href="/icon.png">
    <!-- theme color -->
    <meta name="theme-color" content="#4285f4">
    <style type="text/css">
        @media all and (display-mode: standalone) {
            body {
                background-color: yellow;
            }
        }

    </style>
    {{--    pwa ends--}}
{{--    progressbar--}}
    <style type="text/css">
        #nprogress .bar {
            background: darkblue !important;
        }

        #nprogress .peg {
            box-shadow: 0 0 10px darkblue, 0 0 5px darkblue !important;
        }

        #nprogress .spinner-icon {
            border-top-color: darkblue !important;
            border-left-color: darkblue !important;
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
{{--:remove top and padding top from sidebar stylecss--}}
<!-- ============================================================== -->
<div id="app">
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="/home">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="/icon.png" height="60px" alt="homepage" class="dark-logo"/>
                            <!-- Light Logo icon -->
                            <img src="/icon.png" height="60px" alt="homepage" class="light-logo"/>
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="/logotext.png" alt="homepage" class="dark-logo"/>
                            <!-- Light Logo text -->
                         <img src="/logotext.png" height="22px" style="margin-left: -11px" class="light-logo" alt="homepage"/></span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"><a
                                class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="mdi mdi-menu"></i></a></li>
                        <li class="nav-item"><a
                                class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item hidden-sm-down search-box"><a
                                class="nav-link hidden-sm-down text-muted waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a
                                    class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        @can('list',App\Queue::class)
                        <naive-queues></naive-queues>
                        @endcan
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <naive-notifications></naive-notifications>
                        <naive-messages></naive-messages>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark fillable-user-img" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box" style="word-wrap: break-word;">
                                            <div class="u-img fillable-user-img"></div>
                                            <div class="u-text">
                                                <h4 class="currentUserFullName">UserName</h4>
                                                <p class="text-muted currentUserID"></p>
                                                <p class="text-muted currentUserEmail"></p>
{{--                                                <a href="profile.html"--}}
{{--                                                                                            class="btn btn-rounded btn-danger btn-sm">View--}}
{{--                                                    Profile</a>--}}
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
{{--                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>--}}
                                    <li><router-link to="/MyAccount/FinancialTransactions"><i class="ti-wallet"></i> My Balance</router-link></li>
{{--                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>--}}
{{--                                    <li role="separator" class="divider"></li>--}}
{{--                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>--}}
                                    <li role="separator" class="divider"></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                    <li><a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i> {{ __('Logout') }}</a></li>

                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
{{--                        <li class="nav-item dropdown">--}}
{{--                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""--}}
{{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i--}}
{{--                                    class="flag-icon flag-icon-us"></i></a>--}}
{{--                            <div class="dropdown-menu dropdown-menu-right scale-up"><a class="dropdown-item" href="#"><i--}}
{{--                                        class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i--}}
{{--                                        class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item"--}}
{{--                                                                                          href="#"><i--}}
{{--                                        class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i--}}
{{--                                        class="flag-icon flag-icon-de"></i> Dutch</a></div>--}}
{{--                        </li>--}}
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url(/assets/images/background/user-info.jpg) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img fillable-user-img">
                    </div>

                    <!-- User profile text-->
                    <div class="profile-text"><a href="#" class="dropdown-toggle u-dropdown currentUserFullName"
                                                 data-toggle="dropdown" role="button" aria-haspopup="true"
                                                 aria-expanded="true">User Name</a>
                        <div class="dropdown-menu animated flipInY"><router-link to="/MyProfile/view" class="dropdown-item"><i
                                    class="ti-user"></i> My Profile</router-link> <router-link to="/MyAccount/FinancialTransactions" class="dropdown-item"><i
                                    class="ti-wallet"></i> My Balance</router-link>
{{--                            <a href="#" class="dropdown-item"><i--}}
{{--                                    class="ti-email"></i> Inbox</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>--}}
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                            <naive-link-controller></naive-link-controller>
            <br>
                <hr>
                <br>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <router-link to="/MyAccount/settings" class="link" data-toggle="tooltip" title="Settings"><i
                        class="ti-settings"></i></router-link>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i
                        class="mdi mdi-gmail"></i></a>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-logout"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                @can('viewBreadcrumb',\App\User::class)
                <naive-breadcrumb></naive-breadcrumb>
                @endcan
                @cannot('viewBreadcrumb',App\User::class)
                    <div class="row page-titles">
                        <div class="col-md-5 col-8 align-self-center">
                            <h3 class="text-themecolor">Dashboard</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:window.location.url">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                        <div class="col-md-7 col-4 align-self-center">
                            <div class="d-flex m-t-10 justify-content-end">
                                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                </div>
                                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                </div>
                                <div class="">
                                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcannot
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <router-view></router-view>
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <naive-right-side-bar></naive-right-side-bar>
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">&copy;&nbsp;Student Organization MegaMinds</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<script src="/js/app.js"></script>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="/js/waves.js"></script>
<!--Menu sidebar -->
<script src="/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--stickey kit -->
<script src="/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!-- chartist chart -->
<script src="/assets/plugins/chartist-js/dist/chartist.min.js"></script>
<script src="/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
</body>
<script defer>
    @if(Auth::user()->gender==1)
        window.uimg='<svg id="af854e00-ff52-4b34-bc30-9a0c0757a839" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 676 676"><title>female_avatar</title><path d="M938,450c0,120.33-62.88,225.98-157.58008,285.87q-13.25976,8.4-27.33984,15.55c-2.12012,1.09-4.25,2.14-6.40015,3.17-1.77.86-3.55993,1.7-5.34985,2.53a334.82825,334.82825,0,0,1-57.78,20.47c-1.29.33-2.59009.65-3.89014.96-.97.24-1.94995.47-2.92993.69a2.48782,2.48782,0,0,1-.37.09c-2.01.47-4.0199.92-6.04993,1.33-1.14014.24-2.28.48-3.42005.71-.69006.15-1.39.28-2.07995.41-.87012.17-1.73.33-2.6001.5-.48.1-.96.18-1.45.26-1.1001.2-2.19995.4-3.29.59-1.86.32-3.74.63-5.61.91-1.36.21-2.71.41-4.07.6-1.6001.23-3.19995.44-4.81006.64-.43994.07-.88.12-1.32007.17q-.85473.10492-1.71.21c-1.74.21-3.5.4-5.25.58q-1.70983.18-3.41992.33c-1.47.13995-2.93994.26-4.42.38-1.79993.14-3.59.27-5.4.38-1.15991.07-2.32.14-3.49.2-2.98.16-5.96.27-8.96.35-1.49.04-2.99.07-4.49.09h-.03c-1.49.02-2.99.03-4.49.03A337.82747,337.82747,0,0,1,262,450c0-186.67,151.33008-338,338-338S938,263.33,938,450Z" transform="translate(-262 -112)" fill="#6c63ff"/><path d="M814.11,318.21c-17.36,12.71-32.52991,29.77-45.78992,49.87-37.74,57.19-60.02,139.03-73.18006,215.5-3.36,19.54-6.13,38.73-8.4,57.06-7.82007,63.05-9.85,116.05-10.38,138.69-2.01.47-4.0199.92-6.04993,1.33.34985-17.33,1.59985-54.84,6.01-101.59q.85491-9.06006,1.87988-18.56,1.14-10.68,2.52-21.84c1.9-15.35,4.14-31.26,6.79-47.44q.62988-3.825,1.27-7.6c16.66992-97.79,42.25-172.05,76.33-221.89q20.64-30.21,45.44006-48.39Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M810.43994,584.55c-26.01,19.06-40.57995,61.12-48.72,102.09a556.777,556.777,0,0,0-8.63989,64.78c-2.12012,1.09-4.25,2.14-6.40015,3.17A545.86263,545.86263,0,0,1,756.53,680.9C765.09009,640.32,780.21,599.24,806.88,579.7Z" transform="translate(-262 -112)" opacity="0.2"/><circle cx="585.73826" cy="175.98167" r="30.08857" opacity="0.2"/><circle cx="576.0486" cy="434.99083" r="30.08857" opacity="0.2"/><path d="M728.28551,338.52139c6.38046,35.99732-7.70456,68.59225-7.70456,68.59225s-24.42979-25.76825-30.81025-61.76557,7.70457-68.59225,7.70457-68.59225S721.90506,302.52407,728.28551,338.52139Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M828.28234,423.97122c-34.33494,12.555-68.83676,4.498-68.83676,4.498s21.16612-28.41279,55.50106-40.96784,68.83675-4.498,68.83675-4.498S862.61728,411.41617,828.28234,423.97122Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M834.10466,653.333c-24.066,8.80008-48.28314,3.0594-48.28314,3.0594s14.80161-20.00841,38.86762-28.80849,48.28314-3.0594,48.28314-3.0594S858.17067,644.53292,834.10466,653.333Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M443.85344,292.17875c48.87523-82.584,145.571-86.43279,145.571-86.43279s94.22448-12.04934,154.6689,113.72713c56.339,117.234,134.09405,230.42583,12.51793,257.86946l-21.96018-68.3499-13.59982,73.43847a475.69666,475.69666,0,0,1-52.0179.889C538.83514,579.11657,414.841,584.55,418.83345,537.8294,424.14071,475.721,396.82566,371.64108,443.85344,292.17875Z" transform="translate(-262 -112)" fill="#2f2e41"/><circle cx="336.94555" cy="282.15949" r="123.62315" fill="#d0cde1"/><path d="M658.46781,462.839s-50.365,146.51633,9.15727,187.724S571.47374,719.24259,530.266,691.77078s-73.25816-73.25816-73.25816-73.25816S562.31647,513.204,539.42329,453.68175Z" transform="translate(-262 -112)" fill="#d0cde1"/><path d="M750.04,682.61l-8.71,74.51a334.82825,334.82825,0,0,1-57.78,20.47c-1.29.33-2.59009.65-3.89014.96-.97.24-1.94995.47-2.92993.69a2.48782,2.48782,0,0,1-.37.09c-2.01.47-4.0199.92-6.04993,1.33-1.14014.24-2.28.48-3.42005.71-.69006.15-1.39.28-2.07995.41-.87012.17-1.73.33-2.6001.5-.48.1-.96.18-1.45.26-1.1001.2-2.19995.4-3.29.59-1.86.32-3.74.63-5.61.91-1.36.21-2.71.41-4.07.6-1.6001.23-3.19995.44-4.81006.64-.43994.07-.88.12-1.32007.17q-.85473.10492-1.71.21c-1.74.21-3.5.4-5.25.58q-1.70983.18-3.41992.33c-1.47.13995-2.93994.26-4.42.38-1.79993.14-3.59.27-5.4.38-1.15991.07-2.32.14-3.49.2-2.98.16-5.96.27-8.96.35-1.49.04-2.99.07-4.49.09h-.03c-1.49.02-2.99.03-4.49.03A338.30005,338.30005,0,0,1,304.71,614.59a446.37681,446.37681,0,0,1,46.99-28.13c5.17005-2.61,12.18-4.21,20.19006-5.03,18.09-1.88,41.52991.22,61.86,4.07,18.54,3.48,34.52,8.43,41.57007,13.1,18.31994,12.13,91.58,51.96,91.58,51.96s64.06995,9.16,89.95-9.92c.01,0,.01-.01.02-.01,6.1-4.52,14.53991-4.55,23.85-1.96q2.955.825,6.02,1.97a121.62687,121.62687,0,0,1,16.48,7.85c.12012.07.23.13.3501.2,1.86987,1.05,3.73,2.15,5.56994,3.28C730.92993,665.25,750.04,682.61,750.04,682.61Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M380.25,706.82c-2.96-54.98-6.32007-100.02-8.36-125.39,18.09-1.88,41.52991.22,61.86,4.07,16.55005,33.16,53.85,109.7,88.17993,193.44A336.98776,336.98776,0,0,1,380.25,706.82Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M701.96,648.27l1.22.63C703.06006,650.2,702.77,651,701.96,648.27Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M703.57007,648.69c.01.14.02991.29.03992.43l-.43006-.22c.01-.13.02-.27.04-.41C703.32007,646.74,703.19995,644.67,703.57007,648.69Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M780.41992,735.87q-13.25976,8.4-27.33984,15.55c-2.12012,1.09-4.25,2.14-6.40015,3.17-1.77.86-3.55993,1.7-5.34985,2.53a334.82825,334.82825,0,0,1-57.78,20.47c14.40991-46.53,23.54-92.47,20.05994-128.47l5.53,2.85,26.65,13.73A81.90939,81.90939,0,0,1,756.53,680.9a75.92584,75.92584,0,0,1,5.18994,5.74A82.26163,82.26163,0,0,1,780.38,735C780.39,735.29,780.40991,735.58,780.41992,735.87Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M479.19768,284.21786l95.53072-50.04,59.93613,9.30037a107.1494,107.1494,0,0,1,88.07433,82.22088l11.20767,49.50048-67.94425-2.61328-18.98106-44.28915v43.5591l-31.351-1.20591-18.1964-70.51073-11.37255,75.06L474.64844,372.925Z" transform="translate(-262 -112)" fill="#2f2e41"/></svg>';
    @else
        window.uimg='<svg id="e59edb86-a3bc-4694-8aac-31e565ca5cfc" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 676 676"><title>male_avatar</title><path d="M938,450a336.852,336.852,0,0,1-27.22,133.1L909.66,585.68A338.559,338.559,0,0,1,541.35,782.93q-3.045-.54-6.08-1.12a334.98111,334.98111,0,0,1-61.14-18.03q-4.815-1.935-9.56-4.01c-2.16-.94-4.32-1.91-6.46-2.91A338.41424,338.41424,0,0,1,262,450c0-186.67,151.33-338,338-338S938,263.33,938,450Z" transform="translate(-262 -112)" fill="#6c63ff"/><path d="M541.35,782.93q-3.045-.54-6.08-1.12c-1.32-38.31-5.85-116.94-21.30005-199.29C505.52,537.45,493.79,491.25,477.52,449.95a412.60387,412.60387,0,0,0-19.07-41.84c-16.44-31.05-36.38-57.19-60.56-74.9l3.56-4.86q30.165,22.11,54.22,62.08,7.215,11.97,13.86005,25.54,7.125,14.52,13.59,30.83,4.125,10.38,7.97,21.48,16.74,48.195,28.46,109.98,2.59506,13.65,4.94,27.97C536.6,680.2,540.25,748.59,541.35,782.93Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M464.57,759.77c-2.16-.94-4.32-1.91-6.46-2.91-2.09-22.7-5.93-50.86-12.95-77.59A254.55666,254.55666,0,0,0,433.35,644.07c-8.01-18.75-18.38-34.69-31.79-44.52l3.56-4.85c14.04,10.28,24.87,26.53,33.24,45.54,9.43,21.42,15.72,46.35,19.91,70.17C461.38,728.1,463.34,745.19,464.57,759.77Z" transform="translate(-262 -112)" opacity="0.2"/><circle cx="102.26174" cy="190.98167" r="30.08857" opacity="0.2"/><circle cx="111.9514" cy="449.99083" r="30.08857" opacity="0.2"/><path d="M483.71449,353.52139c-6.38046,35.99732,7.70456,68.59225,7.70456,68.59225s24.42979-25.76825,30.81025-61.76557-7.70457-68.59225-7.70457-68.59225S490.09494,317.52407,483.71449,353.52139Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M383.71766,438.97122c34.33494,12.555,68.83676,4.498,68.83676,4.498s-21.16612-28.41279-55.50106-40.96784-68.83675-4.498-68.83675-4.498S349.38272,426.41617,383.71766,438.97122Z" transform="translate(-262 -112)" opacity="0.2"/><path d="M377.89534,668.333c24.066,8.80008,48.28314,3.0594,48.28314,3.0594S411.37687,651.384,387.31086,642.5839s-48.28314-3.0594-48.28314-3.0594S353.82933,659.53292,377.89534,668.333Z" transform="translate(-262 -112)" opacity="0.2"/><circle cx="337.30608" cy="281.0788" r="131.77014" fill="#d0cde1"/><path d="M547.83337,493.96531s16.47127,78.23852,16.47127,86.47415,78.23852,45.296,78.23852,45.296L712.546,613.382,737.253,539.26129s-41.17817-61.76725-41.17817-86.47415Z" transform="translate(-262 -112)" fill="#d0cde1"/><path d="M910.78,583.1,909.66,585.68A338.559,338.559,0,0,1,541.35,782.93q-3.045-.54-6.08-1.12a334.98111,334.98111,0,0,1-61.14-18.03q-4.815-1.935-9.56-4.01c-2.16-.94-4.32-1.91-6.46-2.91a337.59273,337.59273,0,0,1-55.25-32.28l-15.62-45.31,8.78-6.69995,18.06-13.79,19.27-14.71,5.01-3.83,75.61-57.72,5.58-4.26,39.3-30,.01-.01s42.5,69.25,104.27,48.66,60.42-79.63,60.42-79.63Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M485.03538,286.916s41.83653-90.64581,122.02321-69.72755,125.50958,52.29566,128.996,83.67306-1.74319,78.44348-1.74319,78.44348-8.716-64.498-64.498-50.55247-142.94147,3.48638-142.94147,3.48638L512.9264,457.74849s-15.6887-22.66145-33.12058-8.71594S429.25335,314.807,485.03538,286.916Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M474.13,763.78q-4.815-1.935-9.56-4.01c-2.16-.94-4.32-1.91-6.46-2.91a338.835,338.835,0,0,1-87.59-58.7c9.19-12.52,16.72-18.89,16.72-18.89h61.77l9.26,31.14Z" transform="translate(-262 -112)" fill="#2f2e41"/><path d="M856.67,576.32l52.99,9.36A337.94434,337.94434,0,0,1,852.9,674.25Z" transform="translate(-262 -112)" fill="#2f2e41"/></svg>\n';
    @endif
    $('.fillable-user-img').html(uimg);
    {{--$.get('{{@asset('/profile_img/'.Auth::user()->collegeUID)}}')--}}
    {{--    .done(function() {--}}
    {{--        $('.conditional-profile-image').html('<img height="50px" width="50px" src="{{@asset("/profile_img/".Auth::user()->collegeUID.'.jpg')}}">');--}}
    {{--    }).fail(function() {--}}
    {{--    $('.conditional-profile-image').html('<i class="fa fa-user"></i>');--}}
    {{--});--}}
    window.currentUserID ={{Auth::user()->collegeUID}};
    window.currentUserEmail ="{{Auth::user()->email}}";
    window.currentUserFullName = "{{Auth::user()->firstName.' '.Auth::user()->middleName.' '.Auth::user()->lastName}}";
    document.getElementsByClassName("currentUserFullName").innerHTML = currentUserFullName;
    $(".currentUserFullName").text(currentUserFullName);
    $(".currentUserID").text(currentUserID);
    $(".currentUserEmail").text(currentUserEmail);
//    pwa stuff
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI notify the user they can add to home screen
        btnAdd.style.display = 'block';
    });
    btnAdd.addEventListener('click', (e) => {
        // hide our user interface that shows our A2HS button
        btnAdd.style.display = 'none';
        // Show the prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice
            .then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
    });
    window.addEventListener('appinstalled', (evt) => {
        app.logEvent('a2hs', 'installed');
    });
    if (window.navigator.standalone === true) {
        console.log('display-mode is standalone');
    }
    //pwa ends
</script>
<!--Custom JavaScript -->
<script src="/js/custom.js" defer></script>
</html>

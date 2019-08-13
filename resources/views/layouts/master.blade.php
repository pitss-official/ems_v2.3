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
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="/assets/images/users/1.jpg" alt="user" class="profile-pic"/></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box" style="word-wrap: break-word;">
                                            <div class="u-img"><img src="/assets/images/users/1.jpg" alt="user"></div>
                                            <div class="u-text">
                                                <h4 class="currentUserFullName">UserName</h4>
                                                <p class="text-muted currentUserID"></p>
                                                <p class="text-muted currentUserEmail"></p>
                                                <a href="profile.html"
                                                                                            class="btn btn-rounded btn-danger btn-sm">View
                                                    Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><router-link to="/MyAccount/FinancialTransactions"><i class="ti-wallet"></i> My Balance</router-link></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
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
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="flag-icon flag-icon-us"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"><a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item"
                                                                                          href="#"><i
                                        class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i
                                        class="flag-icon flag-icon-de"></i> Dutch</a></div>
                        </li>
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
                    <div class="profile-img"><img src="/assets/images/users/profile.png" alt="user"/></div>
                    <!-- User profile text-->
                    <div class="profile-text"><a href="#" class="dropdown-toggle u-dropdown currentUserFullName"
                                                 data-toggle="dropdown" role="button" aria-haspopup="true"
                                                 aria-expanded="true">User Name</a>
                        <div class="dropdown-menu animated flipInY"><router-link to="/MyProfile/view" class="dropdown-item"><i
                                    class="ti-user"></i> My Profile</router-link> <router-link to="/MyAccount/FinancialTransactions" class="dropdown-item"><i
                                    class="ti-wallet"></i> My Balance</router-link> <a href="#" class="dropdown-item"><i
                                    class="ti-email"></i> Inbox</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a></div>
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

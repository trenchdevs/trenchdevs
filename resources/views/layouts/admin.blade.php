<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{ env('APP_NAME')  }}</title>
    <link href="admin/css/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="admin/assets/img/favicon.png"/>
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="nav-fixed">
<nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
    <a class="navbar-brand d-none d-sm-block" href="index.html">TrenchDevs Portal</a>
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i
            data-feather="menu"></i></button>
    {{--    <form class="form-inline mr-auto d-none d-lg-block">--}}
    {{--        <input class="form-control form-control-solid mr-sm-2" type="search" placeholder="Search" aria-label="Search"/>--}}
    {{--    </form>--}}
    <ul class="navbar-nav align-items-center ml-auto">
        {{--        <li class="nav-item dropdown no-caret mr-3">--}}
        {{--            <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button"--}}
        {{--               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"--}}
        {{--            >--}}
        {{--                <div class="d-inline d-md-none font-weight-500">Docs</div>--}}
        {{--                <div class="d-none d-md-inline font-weight-500">Documentation</div>--}}
        {{--                <i class="fas fa-chevron-right dropdown-arrow"></i--}}
        {{--                ></a>--}}
        {{--            <div class="dropdown-menu dropdown-menu-right py-0 o-hidden mr-n15 mr-lg-0 animated--fade-in-up"--}}
        {{--                 aria-labelledby="navbarDropdownDocs">--}}
        {{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro" target="_blank"--}}
        {{--                >--}}
        {{--                    <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="book"></i></div>--}}
        {{--                    <div>--}}
        {{--                        <div class="small text-gray-500">Documentation</div>--}}
        {{--                        Usage instructions and reference--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                >--}}
        {{--                <div class="dropdown-divider m-0"></div>--}}
        {{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/components"--}}
        {{--                   target="_blank"--}}
        {{--                >--}}
        {{--                    <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="code"></i></div>--}}
        {{--                    <div>--}}
        {{--                        <div class="small text-gray-500">Components</div>--}}
        {{--                        Code snippets and reference--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                >--}}
        {{--                <div class="dropdown-divider m-0"></div>--}}
        {{--                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/changelog"--}}
        {{--                   target="_blank"--}}
        {{--                >--}}
        {{--                    <div class="icon-stack bg-primary-soft text-primary mr-4"><i data-feather="file-text"></i></div>--}}
        {{--                    <div>--}}
        {{--                        <div class="small text-gray-500">Changelog</div>--}}
        {{--                        Updates and changes--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                >--}}
        {{--            </div>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item dropdown no-caret mr-3 dropdown-notifications">--}}
        {{--            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts"--}}
        {{--               href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"--}}
        {{--               aria-expanded="false"><i data-feather="bell"></i></a>--}}
        {{--            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"--}}
        {{--                 aria-labelledby="navbarDropdownAlerts">--}}
        {{--                <h6 class="dropdown-header dropdown-notifications-header"><i class="mr-2" data-feather="bell"></i>Alerts--}}
        {{--                    Center</h6>--}}
        {{--                <a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                >--}}
        {{--                    <div class="dropdown-notifications-item-icon bg-warning"><i data-feather="activity"></i></div>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-details">December 29, 2019</div>--}}
        {{--                        <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing--}}
        {{--                            serious, but it requires your attention.--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                >--}}
        {{--                    <div class="dropdown-notifications-item-icon bg-info"><i data-feather="bar-chart"></i></div>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-details">December 22, 2019</div>--}}
        {{--                        <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here--}}
        {{--                            to view!--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                >--}}
        {{--                    <div class="dropdown-notifications-item-icon bg-danger"><i class="fas fa-exclamation-triangle"></i>--}}
        {{--                    </div>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-details">December 8, 2019</div>--}}
        {{--                        <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting--}}
        {{--                            down.--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                >--}}
        {{--                    <div class="dropdown-notifications-item-icon bg-success"><i data-feather="user-plus"></i></div>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-details">December 2, 2019</div>--}}
        {{--                        <div class="dropdown-notifications-item-content-text">New user request. Woody has requested--}}
        {{--                            access to the organization.--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-footer" href="#!">View All Alerts</a>--}}
        {{--            </div>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item dropdown no-caret mr-3 dropdown-notifications">--}}
        {{--            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownMessages"--}}
        {{--               href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"--}}
        {{--               aria-expanded="false"><i data-feather="mail"></i></a>--}}
        {{--            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"--}}
        {{--                 aria-labelledby="navbarDropdownMessages">--}}
        {{--                <h6 class="dropdown-header dropdown-notifications-header"><i class="mr-2" data-feather="mail"></i>Message--}}
        {{--                    Center</h6>--}}
        {{--                <a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                ><img class="dropdown-notifications-item-img" src="https://source.unsplash.com/vTL_qy03D1I/60x60"/>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur--}}
        {{--                            adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim--}}
        {{--                            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo--}}
        {{--                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu--}}
        {{--                            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui--}}
        {{--                            officia deserunt mollit anim id est laborum.--}}
        {{--                        </div>--}}
        {{--                        <div class="dropdown-notifications-item-content-details">Emily Fowler · 58m</div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-item" href="#!"--}}
        {{--                ><img class="dropdown-notifications-item-img" src="https://source.unsplash.com/4ytMf8MgJlY/60x60"/>--}}
        {{--                    <div class="dropdown-notifications-item-content">--}}
        {{--                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur--}}
        {{--                            adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim--}}
        {{--                            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo--}}
        {{--                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu--}}
        {{--                            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui--}}
        {{--                            officia deserunt mollit anim id est laborum.--}}
        {{--                        </div>--}}
        {{--                        <div class="dropdown-notifications-item-content-details">Diane Chambers · 2d</div>--}}
        {{--                    </div>--}}
        {{--                </a--}}
        {{--                ><a class="dropdown-item dropdown-notifications-footer" href="#!">Read All Messages</a>--}}
        {{--            </div>--}}
        {{--        </li>--}}
        <li class="nav-item dropdown no-caret mr-3 dropdown-user">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
               href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false"><img class="img-fluid" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"/></a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                 aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"/>
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name">{{ Auth::user()->name() }}</div>
                        <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#!">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a>
                <div class="dropdown-item">
                    <form action="{{ route('logout') }}" method="post">
                    <div class="dropdown-item-icon">
                        <i data-feather="log-out"></i>
                    </div>
                    Logout
                    </form>
                </div>

            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">

                    <div class="sidenav-menu-heading">Core</div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                       data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="nav-link-icon">
                            <i data-feather="users"></i>
                        </div>
                        User Management
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayout">
                            <a class="nav-link" href="layout-static.html">Static Navigation</a><a class="nav-link"
                                                                                                  href="layout-dark.html">Dark
                                Sidenav</a><a class="nav-link" href="layout-rtl.html">RTL Layout</a><a
                                class="nav-link collapsed" href="#" data-toggle="collapse"
                                data-target="#collapseLayoutsPageHeaders" aria-expanded="false"
                                aria-controls="collapseLayoutsPageHeaders"
                            >Page Headers
                                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                                >
                            </a>
                            <div class="collapse" id="collapseLayoutsPageHeaders" data-parent="#accordionSidenavLayout">
                                <nav class="sidenav-menu-nested nav"><a class="nav-link" href="header-simplified.html">Simplified</a><a
                                        class="nav-link" href="header-overlap.html">Content Overlap</a><a
                                        class="nav-link" href="header-breadcrumbs.html">Breadcrumbs</a><a
                                        class="nav-link" href="header-light.html">Light</a></nav>
                            </div>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                       data-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents"
                    >
                        <div class="nav-link-icon"><i data-feather="package"></i></div>
                        Portfolio
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                        >
                    </a>
                    <div class="collapse" id="collapseComponents" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav">
                            <a class="nav-link" href="alerts.html">Alerts</a><a class="nav-link" href="avatars.html">Avatars<span
                                    class="badge badge-primary ml-2">New!</span></a
                            ><a class="nav-link" href="badges.html">Badges</a><a class="nav-link" href="buttons.html">Buttons</a><a
                                class="nav-link" href="cards.html">Cards</a><a class="nav-link" href="dropdowns.html">Dropdowns</a><a
                                class="nav-link" href="forms.html">Forms</a><a class="nav-link" href="modals.html">Modals</a><a
                                class="nav-link" href="navigation.html">Navigation</a><a class="nav-link"
                                                                                         href="progress.html">Progress</a><a
                                class="nav-link" href="toasts.html">Toasts</a><a class="nav-link" href="tooltips.html">Tooltips</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid mt-5">

                <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                    <div class="mr-4 mb-3 mb-sm-0">
                        <h1 class="mb-0">Dashboard</h1>
                        <div class="small">
                            <span class="font-weight-500 text-primary">{{date('l')}}</span> &middot;
                            {{date('F n, Y')}} &middot; {{ date('h:i a') }}
                        </div>
                    </div>
                    <div class="dropdown">
                        <a class="btn btn-white btn-sm font-weight-500 line-height-normal p-3 dropdown-toggle"
                           id="dropdownMenuLink" href="#" role="button" data-toggle="dropdown" data-display="static"
                           aria-haspopup="true" aria-expanded="false"><i class="text-primary mr-2"
                                                                         data-feather="calendar"></i>Jan - Feb 2020</a>
                        <div class="dropdown-menu dropdown-menu-sm-right animated--fade-in"
                             aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="#!">Last 30 days</a><a class="dropdown-item" href="#!">Last
                                week</a><a class="dropdown-item" href="#!">This year</a><a class="dropdown-item"
                                                                                           href="#!">Yesterday</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#!">Custom</a>
                        </div>
                    </div>
                </div>
                @yield('content')

                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold text-blue mb-1">Earnings (monthly)</div>
                                        <div class="h5">$4,390</div>
                                        <div
                                            class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                            <i class="mr-1" data-feather="trending-up"></i>12%
                                        </div>
                                    </div>
                                    <div class="ml-2"><i class="fas fa-dollar-sign fa-2x text-gray-200"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div
                            class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold text-purple mb-1">Average sale price</div>
                                        <div class="h5">$27.00</div>
                                        <div
                                            class="text-xs font-weight-bold text-danger d-inline-flex align-items-center">
                                            <i class="mr-1" data-feather="trending-down"></i>3%
                                        </div>
                                    </div>
                                    <div class="ml-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold text-green mb-1">Clicks</div>
                                        <div class="h5">11,291</div>
                                        <div
                                            class="text-xs font-weight-bold text-success d-inline-flex align-items-center">
                                            <i class="mr-1" data-feather="trending-up"></i>12%
                                        </div>
                                    </div>
                                    <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div
                            class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="small font-weight-bold text-yellow mb-1">Conversion rate</div>
                                        <div class="h5">1.23%</div>
                                        <div
                                            class="text-xs font-weight-bold text-danger d-inline-flex align-items-center">
                                            <i class="mr-1" data-feather="trending-down"></i>1%
                                        </div>
                                    </div>
                                    <div class="ml-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="footer mt-auto footer-light">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; TrenchDevs {{date('Y')}}</div>
                    <div class="col-md-6 text-md-right small">
                        <a href="#!">Privacy Policy</a>
                        &middot;
                        <a href="#!">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="admin/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="admin/assetsdemo/chart-area-demo.js"></script>
<script src="admin/assetsdemo/chart-bar-demo.js"></script>
</body>
</html>

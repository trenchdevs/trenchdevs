@extends('layouts.sbadmin-base')

@section('body')
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="index.html">TrenchDevs Portal</a>
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i
                data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                   href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"><img class="img-fluid"
                                              src="https://source.unsplash.com/QAB-WJcbgJk/60x60"/></a>
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
                    <form action="{{ route('logout') }}" method="post" style="display: inline">
                        {{csrf_field()}}
                        <button type="submit" class="dropdown-item">
                        <span class="dropdown-item-icon">
                            <i data-feather="log-out"></i>
                        </span>
                            Logout
                        </button>
                    </form>

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
                                <a class="nav-link" href="{{ route('users.index') }}">All Users</a>
                                <a class="nav-link" href="{{ route('users.create') }}">Create</a>
{{--                                <a class="nav-link collapsed" href="#" data-toggle="collapse"--}}
{{--                                   data-target="#collapseLayoutsPageHeaders" aria-expanded="false"--}}
{{--                                   aria-controls="collapseLayoutsPageHeaders">Page Headers--}}
{{--                                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                                <div class="collapse" id="collapseLayoutsPageHeaders"--}}
{{--                                     data-parent="#accordionSidenavLayout">--}}
{{--                                    <nav class="sidenav-menu-nested nav">--}}
{{--                                        <a class="nav-  link" href="header-simplified.html">Simplified</a>--}}
{{--                                        <a class="nav-link" href="header-overlap.html">Content Overlap</a>--}}
{{--                                        <a class="nav-link" href="header-breadcrumbs.html">Breadcrumbs</a>--}}
{{--                                        <a class="nav-link" href="header-light.html">Light</a>--}}
{{--                                    </nav>--}}
{{--                                </div>--}}
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
                                <a class="nav-link" href="alerts.html">Alerts</a><a class="nav-link"
                                                                                    href="avatars.html">Avatars<span
                                        class="badge badge-primary ml-2">New!</span></a
                                ><a class="nav-link" href="badges.html">Badges</a><a class="nav-link"
                                                                                     href="buttons.html">Buttons</a><a
                                    class="nav-link" href="cards.html">Cards</a><a class="nav-link"
                                                                                   href="dropdowns.html">Dropdowns</a><a
                                    class="nav-link" href="forms.html">Forms</a><a class="nav-link" href="modals.html">Modals</a><a
                                    class="nav-link" href="navigation.html">Navigation</a><a class="nav-link"
                                                                                             href="progress.html">Progress</a><a
                                    class="nav-link" href="toasts.html">Toasts</a><a class="nav-link"
                                                                                     href="tooltips.html">Tooltips</a>
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

                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif

                    @yield('content')

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
@endsection

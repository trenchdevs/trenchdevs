<x-layouts.sbadmin-base>

    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="/">CloudCraft</a>
        <button class="btn btn-icon btn-transparent-light order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#">
            <i data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <span class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                      href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false"
                >
                    <img
                        class="img-fluid"
                        src="{{ !empty(Auth::user()->avatar_url) ?Auth::user()->avatar_url : '/assets/img/avataaars.svg'  }}"
                    />
                </span>
                <div id="navbarDropdownUserImage"
                     class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                     aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img
                            class="dropdown-user-img"
                            src="{{ !empty(Auth::user()->avatar_url) ? Auth::user()->avatar_url : '/assets/img/avataaars.svg'  }}"
                            alt="avatar image"
                        />
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name">{{ Auth::user()->name() }}</div>
                            <div class="dropdown-user-details-email">{{ Auth::user()->email }}</div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/portfolio/edit">
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
            <nav class="sidenav shadow-right sidenav-dark">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Core</div>
                        <a class="nav-link collapsed" href="/">
                            <div class="nav-link-icon">
                                <i data-feather="activity"></i>
                            </div>
                            Dashboard
                        </a>

                        <a class="nav-link collapsed" href="{{route('cloudcraft.members')}}">
                            <div class="nav-link-icon">
                                <i data-feather="users"></i>
                            </div>
                            Members
                        </a>

                        <a class="nav-link collapsed" target="_blank" href="https://trenchdevs.slack.com">
                            <div class="nav-link-icon">
                                <i data-feather="slack"></i>
                            </div>
                            Slack
                        </a>

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
                <div class="container-fluid mt-3">

                    <div class="d-flex justify-content-end align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="mr-4 mb-3 mb-sm-0">
                            <h6 class="mb-0">Server Time (UTC)</h6>
                            <div class="small">
                                <span class="font-weight-500 text-primary">{{date('l')}}</span> &middot;
                                {{date('F d, Y')}} &middot; {{ date('h:i a') }}
                            </div>
                        </div>
                    </div>

                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif

                    @yield('contents')

                </div>
            </main>
            <footer class="footer mt-auto footer-light">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 small">Copyright &copy; TrenchDevs {{date('Y')}}</div>
                        <div class="col-md-6 text-md-right small">
                            <a href="{{route('documents.privacy')}}" target="_blank">Privacy Policy</a>
                            &middot;
                            <a href="{{route('documents.tnc')}}" target="_blank">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</x-layouts.sbadmin-base>

@extends('layouts.sbadmin-base')

@section('body')
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="/home">TrenchDevs Portal</a>
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i
                data-feather="menu"></i></button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                <span onclick class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
                      href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                      aria-expanded="false"
                >
                    <img
                        class="img-fluid"
                        src="{{ !empty(Auth::user()->avatar_url) ?Auth::user()->avatar_url : '/assets/img/avataaars.svg'  }}"
                    />
                </span>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                     aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img
                            class="dropdown-user-img"
                            src="{{ !empty(Auth::user()->avatar_url) ? Auth::user()->avatar_url : '/assets/img/avataaars.svg'  }}"
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
            <nav class="sidenav shadow-right sidenav-light">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Core</div>
                        <a class="nav-link collapsed" href="/home">
                            <div class="nav-link-icon">
                                <i data-feather="activity"></i>
                            </div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed" href="{{route('portfolio.edit')}}">
                            <div class="nav-link-icon">
                                <i data-feather="user"></i>
                            </div>
                            Account & Profile
                        </a>
                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                           data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                            <div class="nav-link-icon">
                                <i data-feather="briefcase"></i>
                            </div>
                            My Portfolio Page
                            <div class="sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>

                        <div class="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="/portfolio/preview">
                                    <div class="nav-link-icon">
                                        <i data-feather="edit"></i>
                                    </div>
                                    Edit
                                </a>
                                <a class="nav-link" href="/portfolio/preview" target="_blank">
                                    <div class="nav-link-icon">
                                        <i data-feather="eye"></i>
                                    </div>
                                    Page
                                </a>
                            </nav>
                        </div>

                        <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                           data-target="#blogs" aria-expanded="false" aria-controls="blogs">
                            <div class="nav-link-icon">
                                <i data-feather="book-open"></i>
                            </div>
                            Blogs Posts
                            <div class="sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>

                        <div class="collapse" id="blogs" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav">
                                <a class="nav-link" href="/blogs">
                                    <div class="nav-link-icon">
                                        <i data-feather="users"></i>
                                    </div>
                                    All Blog Posts
                                </a>
                                <a class="nav-link" href="/blogs/me">
                                    <div class="nav-link-icon">
                                        <i data-feather="feather"></i>
                                    </div>
                                    My Blog Posts
                                </a>
                            </nav>
                        </div>

                        <div class="sidenav-menu-heading">Modules</div>
                        <a class="nav-link collapsed" href="/admin/shop">
                            <div class="nav-link-icon">
                                <i data-feather="shopping-bag"></i>
                            </div>
                            Shop
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="sidenav-menu-heading">Utilities</div>

                        <a class="nav-link collapsed" href="/accounts">
                            <div class="nav-link-icon">
                                <i data-feather="globe"></i>
                            </div>
                            Accounts
                            {{--                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
                        </a>

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
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="/announcements">
                            <div class="nav-link-icon">
                                <i data-feather="mic"></i>
                            </div>
                            Announcements
                            {{--                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>--}}
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
                <div class="container-fluid mt-5">

                    <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                        <div class="mr-4 mb-3 mb-sm-0">
                            <h1 class="mb-0">@yield('page-header')</h1>

                            <div class="small">
                                <span class="font-weight-500 text-primary">{{date('l')}}</span> &middot;
                                {{date('F n, Y')}} &middot; {{ date('h:i a') }}
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

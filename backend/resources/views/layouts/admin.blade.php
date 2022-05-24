@extends('layouts.sbadmin-base')

@section('body')
    <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
        <a class="navbar-brand d-none d-sm-block" href="{{ route('portal.home')}}">{{site()->company_name}} PORTAL</a>
        <button class="btn btn-icon btn-transparent-light order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#">
            <i data-feather="menu"></i>
        </button>
        <ul class="navbar-nav align-items-center ml-auto">
            <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                @if(route_exists('logout'))
                    <form action="{{route('logout')}}" method="post" style="display: inline">
                        {{csrf_field()}}
                        <button type="submit" class="list-unstyled bg-transparent border-0">
                                <span class="dropdown-item-icon">
                                    <i data-feather="log-out" class="text-white"></i>
                                </span>
                        </button>
                    </form>
                @endif
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sidenav shadow-right sidenav-dark">
                <div class="sidenav-menu">
                    <div class="nav accordion" id="accordionSidenav">
                        <div class="sidenav-menu-heading">Core</div>
                        <a class="nav-link collapsed" href="{{ route('portal.home')}}">
                            <div class="nav-link-icon">
                                <i data-feather="activity"></i>
                            </div>
                            Dashboard
                        </a>
                        @if(route_has_all('portfolio.account'))
                            <a class="nav-link collapsed" href="{{route('portfolio.account')}}">
                                <div class="nav-link-icon">
                                    <i data-feather="user"></i>
                                </div>
                                Account
                            </a>
                        @endif

                        @if(route_has_all('portfolio.edit', 'portfolio.preview'))

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                                <div class="nav-link-icon">
                                    <i data-feather="briefcase"></i>
                                </div>
                                My Portfolio Page
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('portfolio.edit') }}">
                                        <div class="nav-link-icon">
                                            <i data-feather="edit"></i>
                                        </div>
                                        Edit
                                    </a>
                                    <a class="nav-link" href="{{ route('portfolio.preview') }}" target="_blank">
                                        <div class="nav-link-icon">
                                            <i data-feather="eye"></i>
                                        </div>
                                        Page
                                    </a>
                                </nav>
                            </div>
                        @endif

                        @if(route_exists('admin.photos.index'))
                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                                <div class="nav-link-icon">
                                    <i data-feather="briefcase"></i>
                                </div>
                                Photos
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{ route('admin.photos.index') }}">
                                        <div class="nav-link-icon">
                                            <i data-feather="edit"></i>
                                        </div>
                                        All Photos
                                    </a>
                                    <a class="nav-link" href="{{ route('admin.photos.albums') }}">
                                        <div class="nav-link-icon">
                                            <i data-feather="eye"></i>
                                        </div>
                                        Photo Albums
                                    </a>
                                </nav>
                            </div>
                        @endif

                        @if(route_has_any('public.blogs', 'blogs.upsert', 'blogs.index'))


                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#blogs" aria-expanded="false" aria-controls="blogs">
                                <div class="nav-link-icon">
                                    <i data-feather="edit-3"></i>
                                </div>
                                Blogs
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="blogs" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">

                                    @if(route_has_all('public.blogs'))
                                        <a class="nav-link" href="{{route('public.blogs')}}">
                                            <div class="nav-link-icon">
                                                <i data-feather="book-open"></i>
                                            </div>
                                            Blog Page
                                        </a>
                                    @endif
                                    <a class="nav-link" href="{{route('blogs.upsert')}}">
                                        <div class="nav-link-icon">
                                            <i data-feather="plus-square"></i>
                                        </div>
                                        Create
                                    </a>
                                    <a class="nav-link" href="{{route('blogs.index')}}">
                                        <div class="nav-link-icon">
                                            <i data-feather="users"></i>
                                        </div>
                                        All Blogs
                                    </a>
                                    <a class="nav-link" href="{{route('blogs.index', ['me' => '1'])}}">
                                        <div class="nav-link-icon">
                                            <i data-feather="feather"></i>
                                        </div>
                                        My Blogs
                                    </a>
                                </nav>
                            </div>
                        @endif

                        @if(route_has_all('users.index'))
                            <a class="nav-link collapsed" href="{{ route('users.index') }}">
                                <div class="nav-link-icon">
                                    <i data-feather="users"></i>
                                </div>
                                Users
                            </a>
                        @endif

                        @if(route_has_all('projects.list'))
                            <a class="nav-link collapsed" href="{{route('projects.list')}}">
                                <div class="nav-link-icon">
                                    <i data-feather="paperclip"></i>
                                </div>
                                Projects
                            </a>
                        @endif

                        @if(site()->theme == 'trenchdevs')
                            <a class="nav-link collapsed" target="_blank" href="https://trenchdevs.slack.com">
                                <div class="nav-link-icon">
                                    <i data-feather="slack"></i>
                                </div>
                                Slack
                            </a>
                        @endif

                        @if(route_has_all('accounts.index'))
                            <a class="nav-link collapsed"
                               href="{{ route('accounts.index') }}">
                                <div class="nav-link-icon">
                                    <i data-feather="pen-tool"></i>
                                </div>
                                Markdown Notes
                            </a>
                        @endif

                        @if(site()->theme == 'trenchdevs')
                            <div class="sidenav-menu-heading">Git</div>

                            <a class="nav-link collapsed" target="_blank"
                               href="https://github.com/trenchdevs/trenchdevs/issues">
                                <div class="nav-link-icon">
                                    <i data-feather="alert-circle"></i>
                                </div>
                                Issues
                            </a>

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#repositories" aria-expanded="false" aria-controls="repositories">
                                <div class="nav-link-icon">
                                    <i data-feather="book-open"></i>
                                </div>
                                Repositories
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="repositories" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a target="_blank" class="nav-link"
                                       href="https://github.com/trenchdevs/trenchdevs">
                                        <div class="nav-link-icon">
                                            <i data-feather="code"></i>
                                        </div>
                                        trenchdevs
                                    </a>
                                    <a target="_blank" class="nav-link"
                                       href="https://github.com/christopheredrian/trenchdevs-php-client">
                                        <div class="nav-link-icon">
                                            <i data-feather="code"></i>
                                        </div>
                                        trenchdevs-php-client
                                    </a>
                                </nav>
                            </div>



                            <div class="sidenav-menu-heading">Modules</div>

                            @if(!empty(config('samlidp')) && $user->role === \App\Domains\Users\Models\User::ROLE_SUPER_ADMIN)
                                <a class="nav-link collapsed"
                                   href="{{config('samlidp.sp.login_url')}}">
                                    <div class="nav-link-icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                    SSO
                                </a>
                            @endif

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#api-clients" aria-expanded="false" aria-controls="api-clients">
                                <div class="nav-link-icon">
                                    <i data-feather="book-open"></i>
                                </div>
                                API Clients
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="api-clients" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a target="_blank" class="nav-link"
                                       href="https://packagist.org/packages/trenchdevs/trenchdevs-php-client">
                                        <div class="nav-link-icon">
                                            <i data-feather="code"></i>
                                        </div>
                                        Php Client
                                    </a>
                                </nav>
                            </div>

                        @endif


                        @if(route_exists('shop.products.show-bulk-upload') && Auth::user()->canManageShop())

                            <a class="nav-link collapsed" href="javascript:void(0);" data-toggle="collapse"
                               data-target="#shop" aria-expanded="false" aria-controls="shop">
                                <div class="nav-link-icon">
                                    <i data-feather="shopping-bag"></i>
                                </div>
                                Shop
                                <div class="sidenav-collapse-arrow">
                                    <i data-feather="chevron-down"></i>
                                </div>
                            </a>

                            <div class="collapse" id="shop" data-parent="#accordionSidenav">
                                <nav class="sidenav-menu-nested nav">
                                    <a class="nav-link" href="{{route('shop.products.show-bulk-upload')}}">
                                        <div class="nav-link-icon">
                                            <i data-feather="upload"></i>
                                        </div>
                                        Product Bulk Upload
                                    </a>
                                </nav>
                            </div>

                        @endif

                        @if(route_has_any('accounts.index', 'announcements.index', 'superadmin.command'))
                            <div class="sidenav-menu-heading">Utilities</div>
                        @endif

                        @if(route_has_all('accounts.index'))
                            <a class="nav-link collapsed" href="{{ route('accounts.index') }}">
                                <div class="nav-link-icon">
                                    <i data-feather="globe"></i>
                                </div>
                                Accounts
                            </a>
                        @endif


                        @if(route_has_all('announcements.index'))
                            <a class="nav-link collapsed" href="{{route('announcements.index')}}">
                                <div class="nav-link-icon">
                                    <i data-feather="mic"></i>
                                </div>
                                Announcements
                            </a>

                        @endif

                        @if(false)
                            <a class="nav-link collapsed" href="{{route('superadmin.command')}}">
                                <div class="nav-link-icon">
                                    <i data-feather="terminal"></i>
                                </div>
                                Commands
                            </a>
                        @endif
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

                    @yield('content')

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
@endsection

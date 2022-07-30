import React, {useState} from 'react';


export default function TrenchDevsAdminLayout({auth, header, children}) {

    return (
        <>
            <nav className="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
                <a className="navbar-brand d-none d-sm-block"
                   href="/dashboard">TRENCHDEVS PORTAL</a>
                <button className="btn btn-icon btn-transparent-light order-1 order-lg-0 mr-lg-2" id="sidebarToggle"
                        href="#">
                    <i data-feather="menu"></i>
                </button>
                <ul className="navbar-nav align-items-center ml-auto">
                    <li className="nav-item dropdown no-caret mr-3 dropdown-user">
                        <form method="post">
                            <button type="submit" className="list-unstyled bg-transparent border-0">
                                <span className="dropdown-item-icon">
                                    <i data-feather="log-out" className="text-white"></i>
                                </span>
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav className="sidenav shadow-right sidenav-dark">
                        <div className="sidenav-menu">
                            <div className="nav accordion" id="accordionSidenav">
                                <div className="sidenav-menu-heading">Core</div>
                                <a className="nav-link collapsed" href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="activity"></i>
                                    </div>
                                    Dashboard
                                </a>
                                <a className="nav-link collapsed" href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="user"></i>
                                    </div>
                                    Account
                                </a>


                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                                    <div className="nav-link-icon">
                                        <i data-feather="briefcase"></i>
                                    </div>
                                    My Portfolio Page
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">
                                        <a className="nav-link" href=" ">
                                            <div className="nav-link-icon">
                                                <i data-feather="edit"></i>
                                            </div>
                                            Edit
                                        </a>
                                        <a className="nav-link" href=" " target="_blank">
                                            <div className="nav-link-icon">
                                                <i data-feather="eye"></i>
                                            </div>
                                            Page
                                        </a>
                                    </nav>
                                </div>

                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                                    <div className="nav-link-icon">
                                        <i data-feather="briefcase"></i>
                                    </div>
                                    Photos
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">
                                        <a className="nav-link" href="index">
                                            <div className="nav-link-icon">
                                                <i data-feather="edit"></i>
                                            </div>
                                            All Photos
                                        </a>
                                        <a className="nav-link" href="albums">
                                            <div className="nav-link-icon">
                                                <i data-feather="eye"></i>
                                            </div>
                                            Photo Albums
                                        </a>
                                    </nav>
                                </div>


                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#blogs" aria-expanded="false" aria-controls="blogs">
                                    <div className="nav-link-icon">
                                        <i data-feather="edit-3"></i>
                                    </div>
                                    Blogs
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="blogs" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">


                                        <a className="nav-link" href="">
                                            <div className="nav-link-icon">
                                                <i data-feather="book-open"></i>
                                            </div>
                                            Blog Page
                                        </a>

                                        <a className="nav-link" href="">
                                            <div className="nav-link-icon">
                                                <i data-feather="plus-square"></i>
                                            </div>
                                            Create
                                        </a>
                                        <a className="nav-link" href="">
                                            <div className="nav-link-icon">
                                                <i data-feather="users"></i>
                                            </div>
                                            All Blogs
                                        </a>
                                        <a className="nav-link" href=" ['me' => '1'])">
                                            <div className="nav-link-icon">
                                                <i data-feather="feather"></i>
                                            </div>
                                            My Blogs
                                        </a>
                                    </nav>
                                </div>


                                <a className="nav-link collapsed" href=" ">
                                    <div className="nav-link-icon">
                                        <i data-feather="users"></i>
                                    </div>
                                    Users
                                </a>


                                <a className="nav-link collapsed" href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="paperclip"></i>
                                    </div>
                                    Projects
                                </a>


                                <a className="nav-link collapsed" target="_blank" href="https://trenchdevs.slack.com">
                                    <div className="nav-link-icon">
                                        <i data-feather="slack"></i>
                                    </div>
                                    Slack
                                </a>


                                <a className="nav-link collapsed"
                                   href=" ">
                                    <div className="nav-link-icon">
                                        <i data-feather="pen-tool"></i>
                                    </div>
                                    Markdown Notes
                                </a>


                                <div className="sidenav-menu-heading">Git</div>

                                <a className="nav-link collapsed" target="_blank"
                                   href="https://github.com/trenchdevs/trenchdevs/issues">
                                    <div className="nav-link-icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                    Issues
                                </a>

                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#repositories" aria-expanded="false" aria-controls="repositories">
                                    <div className="nav-link-icon">
                                        <i data-feather="book-open"></i>
                                    </div>
                                    Repositories
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="repositories" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">
                                        <a target="_blank" className="nav-link"
                                           href="https://github.com/trenchdevs/trenchdevs">
                                            <div className="nav-link-icon">
                                                <i data-feather="code"></i>
                                            </div>
                                            trenchdevs
                                        </a>
                                        <a target="_blank" className="nav-link"
                                           href="https://github.com/christopheredrian/trenchdevs-php-client">
                                            <div className="nav-link-icon">
                                                <i data-feather="code"></i>
                                            </div>
                                            trenchdevs-php-client
                                        </a>
                                    </nav>
                                </div>


                                <div className="sidenav-menu-heading">Modules</div>

                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#api-clients" aria-expanded="false" aria-controls="api-clients">
                                    <div className="nav-link-icon">
                                        <i data-feather="book-open"></i>
                                    </div>
                                    API Clients
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="api-clients" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">
                                        <a target="_blank" className="nav-link"
                                           href="https://packagist.org/packages/trenchdevs/trenchdevs-php-client">
                                            <div className="nav-link-icon">
                                                <i data-feather="code"></i>
                                            </div>
                                            Php Client
                                        </a>
                                    </nav>
                                </div>


                                <div className="sidenav-menu-heading">SSO</div>


                                <a className="nav-link collapsed"
                                   href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="alert-circle"></i>
                                    </div>
                                </a>


                                <a className="nav-link collapsed" data-toggle="collapse"
                                   data-target="#shop" aria-expanded="false" aria-controls="shop">
                                    <div className="nav-link-icon">
                                        <i data-feather="shopping-bag"></i>
                                    </div>
                                    Shop
                                    <div className="sidenav-collapse-arrow">
                                        <i data-feather="chevron-down"></i>
                                    </div>
                                </a>

                                <div className="collapse" id="shop" data-parent="#accordionSidenav">
                                    <nav className="sidenav-menu-nested nav">
                                        <a className="nav-link" href="show-bulk-upload">
                                            <div className="nav-link-icon">
                                                <i data-feather="upload"></i>
                                            </div>
                                            Product Bulk Upload
                                        </a>
                                    </nav>
                                </div>


                                <div className="sidenav-menu-heading">Utilities</div>


                                <a className="nav-link collapsed" href=" ">
                                    <div className="nav-link-icon">
                                        <i data-feather="globe"></i>
                                    </div>
                                    Accounts
                                </a>


                                <a className="nav-link collapsed" href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="mic"></i>
                                    </div>
                                    Announcements
                                </a>


                                <a className="nav-link collapsed" href="">
                                    <div className="nav-link-icon">
                                        <i data-feather="terminal"></i>
                                    </div>
                                    Commands
                                </a>

                            </div>
                        </div>
                        <div className="sidenav-footer">
                            <div className="sidenav-footer-content">
                                <div className="sidenav-footer-subtitle">Logged in as:</div>
                                <div
                                    className="sidenav-footer-title">first_name last_name
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content">
                    <main>
                        <div className="container-fluid mt-3">

                            <div
                                className="d-flex justify-content-end align-items-sm-center flex-column flex-sm-row mb-4">
                                <div className="mr-4 mb-3 mb-sm-0">
                                    <h6 className="mb-0">Server Time (UTC)</h6>
                                    <div className="small">
                                        <span className="font-weight-500 text-primary"></span> &middot;

                                    </div>
                                </div>
                            </div>

                            <p className="alert class', 'alert-info"></p>

                            {children}

                        </div>
                    </main>
                    <footer className="footer mt-auto footer-light">
                        <div className="container-fluid">
                            <div className="row">
                                <div className="col-md-6 small">Copyright &copy; TrenchDevs</div>
                                <div className="col-md-6 text-md-right small">
                                    <a href="" target="_blank">Privacy Policy</a>
                                    &middot;
                                    <a href="" target="_blank">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>

        </>
    );
}

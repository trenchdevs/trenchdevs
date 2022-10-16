import React, {useState} from 'react';
import * as Icon from 'react-feather';
import {Link, usePage} from "@inertiajs/inertia-react";
import {get} from 'lodash';

const ICON_DEFAULT_PROPS = {color: 'grey', size: 18}


export default function TrenchDevsAdminLayout(props) {

    const {props: pageProps, component, url} = usePage();

    props = {
        ...pageProps,
        ...props
    };

    const {
        flash = {},
        server = {},
        auth: {user = {}},
        site = {},
        children
    } = props;


    return (
        <>
            <nav className="topnav navbar navbar-expand shadow navbar-light bg-white z-0" id="sidenavAccordion">
                <a className="navbar-brand d-none d-sm-block"
                   href="/dashboard">{site.company_name} </a>
                <button className="btn btn-icon btn-transparent-light order-1 order-lg-0 mr-lg-2" id="sidebarToggle"
                        onClick={() => $("body").toggleClass("sidenav-toggled")}
                        href="#">
                    <Icon.Menu {...ICON_DEFAULT_PROPS} color="white"/>
                </button>
                <ul className="navbar-nav align-items-center ml-auto mt-2">
                    <li className="nav-item dropdown no-caret mr-3 dropdown-user">
                        <Link href="/logout" as={"button"} method={"post"}
                              className="list-unstyled bg-transparent border-0">
                                <span className="dropdown-item-icon">
                                    <Icon.LogOut size={ICON_DEFAULT_PROPS.size} color={"white"}/>
                                </span>
                        </Link>
                    </li>
                </ul>
            </nav>

            <div id="layoutSidenav">
                <SidebarNav
                    site={site}
                    url={url}
                    user={user}
                />
                <div id="layoutSidenav_content">
                    <main>
                        <div className="container-fluid mt-3">

                            <div
                                className="d-flex justify-content-end align-items-sm-center flex-column flex-sm-row mb-4">
                                <div className="mr-4 mb-3 mb-sm-0">
                                    <h6 className="mb-0">Server Time (UTC)</h6>
                                    <div className="small">
                                        <span className="font-weight-500 text-primary">
                                            {get(server, 'time.day_of_week')}</span>  &middot;
                                        {get(server, 'time.date_human')} &middot;
                                        {get(server, 'time.time_human')}

                                    </div>
                                </div>
                            </div>

                            {
                                flash && flash.message && !flash.error_message &&
                                <p className="alert alert-info">{flash.message}</p>
                            }

                            {
                                flash && flash.error_message &&
                                <p className="alert alert-danger">{flash.error_message}</p>
                            }

                            <div>
                                {children}
                            </div>

                        </div>
                    </main>
                    <footer className="footer mt-auto footer-light my-3">
                        <div className="container-fluid">
                            <div className="row">
                                <div className="col-md-6 small">Copyright &copy; TrenchDevs</div>
                                <div className="col-md-6 text-md-right small">
                                    <a href="/documents/privacy" target="_blank">Privacy Policy</a>
                                    &middot;
                                    <a href="/documents/tnc" target="_blank">Terms &amp; Conditions</a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>

        </>
    );
}

function SidebarNav({
                        url,
                        site = {},
                        user = {},
                    }) {

    function returnClassOnAnyUrls(routes, classes) {

        for (const route of routes) {
            if (url.startsWith(route)) {
                return classes;
            }
        }
    }

    let absolutePortfolioUrl = false;

    if (user.external_id) {
        absolutePortfolioUrl = `/${user.external_id}`;
    }

    const MODULES = {
        PORTFOLIO_ENABLED: site.configs.portfolio_module_enabled === '1',
        USERS_ENABLED: site.configs.users_module_enabled === '1',
        DASHBOARD_ENABLED: site.configs.dashboard_module_enabled === '1',
        PHOTOS_ENABLED: site.configs.photos_module_enabled === '1',
        ANNOUNCEMENT_ENABLED: site.configs.announcement_module_enabled === '1',
        BLOGS_ENABLED: site.configs.blogs_module_enabled === '1',
        PROJECTS_ENABLED: site.configs.projects_module_enabled === '1'
    };


    return (
        <>
            <div id="layoutSidenav_nav">
                <nav className="sidenav shadow-right sidenav-dark">
                    <div className="sidenav-menu">
                        <div className="nav accordion" id="accordionSidenav">
                            <div className="sidenav-menu-heading">Core</div>

                            {
                                MODULES.DASHBOARD_ENABLED &&
                                <Link className={`nav-link collapsed ${url.toLowerCase() === '/dashboard' && 'active'}`}
                                      href="/dashboard">
                                    <div className="nav-link-icon">
                                        <Icon.Activity {...ICON_DEFAULT_PROPS}/>
                                    </div>
                                    Dashboard
                                </Link>
                            }

                            <Link href="/dashboard/account/change-password"
                                  className={`nav-link collapsed ${url.startsWith('/dashboard/account/') && 'active'}`}>
                                <div className="nav-link-icon">
                                    <Icon.Lock {...ICON_DEFAULT_PROPS}/>
                                </div>
                                Account
                            </Link>


                            {
                                MODULES.PORTFOLIO_ENABLED &&
                                <>
                                    <a className={`nav-link collapsed ${returnClassOnAnyUrls(['/dashboard/portfolio'], 'active')}`}
                                       data-toggle="collapse"
                                       data-target="#my-portfolio" aria-expanded="false" aria-controls="my-portfolio">
                                        <div className="nav-link-icon">
                                            <Icon.Briefcase {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Portfolio
                                        <div className="sidenav-collapse-arrow">
                                            <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                    </a>

                                    <div className="collapse" id="my-portfolio" data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <Link className="nav-link" href="/dashboard/portfolio/details">
                                                <div className="nav-link-icon">
                                                    <Icon.Edit {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                Edit
                                            </Link>
                                            <a
                                                className="nav-link"
                                                href={absolutePortfolioUrl ? absolutePortfolioUrl : "#"}
                                                onClick={e => {
                                                    e.preventDefault();
                                                    if (!absolutePortfolioUrl) {
                                                        alert("You need to setup your portfolio first");
                                                    } else {
                                                        window.location.href = absolutePortfolioUrl;
                                                    }
                                                }}
                                                target="_blank"
                                                title={'Your public portfolio page'}
                                            >
                                                <div className="nav-link-icon">
                                                    <Icon.Eye {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                My Portfolio Page
                                            </a>
                                        </nav>
                                    </div>
                                </>
                            }

                            {
                                MODULES.PHOTOS_ENABLED &&
                                <>
                                    <a className="nav-link collapsed" data-toggle="collapse"
                                       data-target="#photos-module" aria-expanded="false" aria-controls="photos-module">
                                        <div className="nav-link-icon">
                                            <Icon.UploadCloud {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Photos
                                        <div className="sidenav-collapse-arrow">
                                            <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                    </a>

                                    <div className="collapse" id="photos-module" data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <Link href="/dashboard/photos" className="nav-link">
                                                <div className="nav-link-icon">
                                                    <Icon.Edit {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                All
                                            </Link>
                                            {/*<a className="nav-link" href="">*/}
                                            {/*    <div className="nav-link-icon">*/}
                                            {/*        <Icon.Eye {...ICON_DEFAULT_PROPS}/>*/}
                                            {/*    </div>*/}
                                            {/*    Photo Albums*/}
                                            {/*</a>*/}
                                        </nav>
                                    </div>
                                </>
                            }


                            {
                                MODULES.BLOGS_ENABLED &&
                                <>
                                    <a className={`nav-link collapsed ${url.startsWith('/dashboard/blogs') && 'active'}`}
                                       data-toggle="collapse"
                                       data-target="#blogs" aria-expanded="false" aria-controls="blogs">
                                        <div className="nav-link-icon">
                                            <Icon.Edit3 {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Blogs
                                        <div className="sidenav-collapse-arrow">
                                            <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                    </a>

                                    <div className={`collapse ${url.startsWith('/dashboard/blogs') && 'show'}`}
                                         id="blogs"
                                         data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <a className="nav-link" href="/blogs" target="_blank">
                                                <div className="nav-link-icon">
                                                    <Icon.BookOpen {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                Public Page
                                            </a>

                                            <Link className="nav-link" href="/dashboard/blogs/upsert">
                                                <div className="nav-link-icon">
                                                    <Icon.PlusSquare{...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                Create
                                            </Link>
                                            <Link className="nav-link" href="/dashboard/blogs">
                                                <div className="nav-link-icon">
                                                    <Icon.Users{...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                All Blogs
                                            </Link>
                                            {/*<a className="nav-link" href="@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout">*/}
                                            {/*    <div className="nav-link-icon">*/}
                                            {/*        <Icon.Feather{...ICON_DEFAULT_PROPS}/>*/}
                                            {/*    </div>*/}
                                            {/*    My Blogs*/}
                                            {/*</a>*/}
                                        </nav>
                                    </div>
                                </>
                            }


                            {
                                MODULES.USERS_ENABLED &&
                                <Link className={`nav-link collapsed ${url.startsWith('/dashboard/users') && 'active'}`}
                                      href="/dashboard/users">
                                    <div className="nav-link-icon">
                                        <Icon.Users{...ICON_DEFAULT_PROPS}/>
                                    </div>
                                    Users
                                </Link>
                            }


                            {
                                MODULES.PROJECTS_ENABLED &&
                                <Link href={"/dashboard/projects"}
                                      className={`nav-link collapsed ${url.startsWith('/dashboard/projects') && 'active'}`}>
                                    <div className="nav-link-icon">
                                        <Icon.Paperclip{...ICON_DEFAULT_PROPS}/>
                                    </div>
                                    Projects
                                </Link>
                            }


                            {
                                site.identifier === 'trenchdevs' &&
                                <>
                                    <a className="nav-link collapsed" target="_blank"
                                       href="https://trenchdevs.slack.com">
                                        <div className="nav-link-icon">
                                            <Icon.Slack{...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Slack
                                    </a>


                                    {/*<a className="nav-link collapsed"*/}
                                    {/*   href=" ">*/}
                                    {/*    <div className="nav-link-icon">*/}
                                    {/*        <Icon.PenTool{...ICON_DEFAULT_PROPS}/>*/}
                                    {/*    </div>*/}
                                    {/*    Markdown Notes*/}
                                    {/*</a>*/}


                                    <div className="sidenav-menu-heading">Git</div>

                                    <a className="nav-link collapsed" target="_blank"
                                       href="https://github.com/trenchdevs/trenchdevs/issues">
                                        <div className="nav-link-icon">
                                            <Icon.AlertCircle {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Issues
                                    </a>

                                    <a className="nav-link collapsed" data-toggle="collapse"
                                       data-target="#repositories" aria-expanded="false" aria-controls="repositories">
                                        <div className="nav-link-icon">
                                            <Icon.BookOpen {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Repositories
                                        <div className="sidenav-collapse-arrow">
                                            <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                    </a>

                                    <div className="collapse" id="repositories" data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <a target="_blank" className="nav-link"
                                               href="https://github.com/trenchdevs/trenchdevs">
                                                <div className="nav-link-icon">
                                                    <Icon.Code {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                trenchdevs
                                            </a>
                                            <a target="_blank" className="nav-link"
                                               href="https://github.com/christopheredrian/trenchdevs-php-client">
                                                <div className="nav-link-icon">
                                                    <Icon.Code {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                trenchdevs-php-client
                                            </a>
                                        </nav>
                                    </div>


                                    <div className="sidenav-menu-heading">Modules</div>

                                    <a className="nav-link collapsed" data-toggle="collapse"
                                       data-target="#api-clients" aria-expanded="false" aria-controls="api-clients">
                                        <div className="nav-link-icon">
                                            <Icon.BookOpen {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        API Clients
                                        <div className="sidenav-collapse-arrow">
                                            <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>
                                        </div>
                                    </a>

                                    <div className="collapse" id="api-clients" data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <a target="_blank" className="nav-link"
                                               href="https://packagist.org/packages/trenchdevs/trenchdevs-php-client">
                                                <div className="nav-link-icon">
                                                    <Icon.Code {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                Php Client
                                            </a>
                                        </nav>
                                    </div>

                                    {/*<a className="nav-link collapsed" data-toggle="collapse"*/}
                                    {/*   data-target="#shop" aria-expanded="false" aria-controls="shop">*/}
                                    {/*    <div className="nav-link-icon">*/}
                                    {/*        <Icon.ShoppingBag {...ICON_DEFAULT_PROPS}/>*/}
                                    {/*    </div>*/}
                                    {/*    Shop*/}
                                    {/*    <div className="sidenav-collapse-arrow">*/}
                                    {/*        <Icon.ChevronDown {...ICON_DEFAULT_PROPS}/>*/}
                                    {/*    </div>*/}
                                    {/*</a>*/}

                                    <div className="collapse" id="shop" data-parent="#accordionSidenav">
                                        <nav className="sidenav-menu-nested nav">
                                            <a className="nav-link" href="show-bulk-upload">
                                                <div className="nav-link-icon">
                                                    <Icon.Upload {...ICON_DEFAULT_PROPS}/>
                                                </div>
                                                Product Bulk Upload
                                            </a>
                                        </nav>
                                    </div>
                                </>
                            }


                            {/*@if(!empty(config('samlidp.sp.login_url')))*/}
                            {/*<a class="nav-link collapsed"*/}
                            {/*   href="{{config('samlidp.sp.login_url')}}">*/}
                            {/*    <div class="nav-link-icon">*/}
                            {/*        <i data-feather="alert-circle"></i>*/}
                            {/*    </div>*/}
                            {/*    {{config('samlidp.sp.login_label', 'SSO')}}*/}
                            {/*</a>*/}
                            {/*@endif*/}


                            {/*<a className="nav-link collapsed" href=" ">*/}
                            {/*    <div className="nav-link-icon">*/}
                            {/*        <Icon.Globe {...ICON_DEFAULT_PROPS}/>*/}
                            {/*    </div>*/}
                            {/*    Accounts*/}
                            {/*</a>*/}


                            {
                                MODULES.ANNOUNCEMENT_ENABLED &&
                                <>
                                    <div className="sidenav-menu-heading">Utilities</div>

                                    <Link
                                        href={"/dashboard/announcements"}
                                        className={`nav-link collapsed ${url.startsWith('/dashboard/announcements') && 'active'}`}
                                    >
                                        <div className="nav-link-icon">
                                            <Icon.Mic{...ICON_DEFAULT_PROPS}/>
                                        </div>
                                        Announcements
                                    </Link>
                                </>
                            }


                            {/*<a className="nav-link collapsed" href="">*/}
                            {/*    <div className="nav-link-icon">*/}
                            {/*        <Icon.Terminal{...ICON_DEFAULT_PROPS}/>*/}
                            {/*    </div>*/}
                            {/*    Commands*/}
                            {/*</a>*/}

                        </div>
                    </div>
                    <div className="sidenav-footer">
                        <div className="sidenav-footer-content">
                            <div className="sidenav-footer-subtitle">Logged in as:</div>
                            <div className="sidenav-footer-title">
                                {user.name} <br/> <small>{user.email}</small>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </>
    );
}

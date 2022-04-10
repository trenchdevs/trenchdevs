<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Rental - SB Admin Pro</title>
    <link href="/sbui/css/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"
            crossorigin="anonymous"></script>
</head>
<body>
<div id="layoutDefault">
    <div id="layoutDefault_content">
        <main>
            <nav class="navbar navbar-marketing navbar-expand-lg bg-white navbar-light">
                <div class="container">
                    <a class="navbar-brand text-dark" href="index.html">{{ $site->company_name }}</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mr-lg-5">
                            <li class="nav-item"><a class="nav-link" href="index.html">Home </a></li>
                            <li class="nav-item dropdown no-caret">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <i class="fas fa-chevron-right dropdown-arrow"></i></a>
                                <div class="dropdown-menu dropdown-menu-right animated--fade-in-up"
                                     aria-labelledby="navbarDropdownDocs">
                                    <a class="dropdown-item py-3"
                                       href="https://docs.startbootstrap.com/sb-ui-kit-pro/quickstart" target="_blank"
                                    >
                                        <div class="icon-stack bg-primary-soft text-primary mr-4"><i
                                                class="fas fa-book-open"></i></div>
                                        <div>
                                            <div class="small text-gray-500">Documentation</div>
                                            Usage instructions and reference
                                        </div>
                                    </a
                                    >
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3"
                                       href="https://docs.startbootstrap.com/sb-ui-kit-pro/components" target="_blank"
                                    >
                                        <div class="icon-stack bg-primary-soft text-primary mr-4"><i
                                                class="fas fa-code"></i></div>
                                        <div>
                                            <div class="small text-gray-500">Components</div>
                                            Code snippets and reference
                                        </div>
                                    </a
                                    >
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3"
                                       href="https://docs.startbootstrap.com/sb-ui-kit-pro/changelog" target="_blank"
                                    >
                                        <div class="icon-stack bg-primary-soft text-primary mr-4"><i
                                                class="fas fa-file"></i></div>
                                        <div>
                                            <div class="small text-gray-500">Changelog</div>
                                            Updates and changes
                                        </div>
                                    </a
                                    >
                                </div>
                            </li>
                        </ul>
                        <a class="btn-primary btn rounded-pill px-4 ml-lg-4"
                           href="https://shop.startbootstrap.com/sb-ui-kit-pro">
                            Book Now
                            <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </nav>
            <header class="page-header page-header-light bg-img-cover overlay overlay-light overlay-80"
                    style='background-image: url("https://source.unsplash.com/R-LK3sqLiBw/1600x1200")'>
                <div class="page-header-content py-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-10 text-center">
                                <h1 class="page-header-title">{{ site_get_config_from_json('pages::home_contents', 'header', 'Rent your home or extra room') }}</h1>
                                <p class="page-header-text mb-5">
                                    {{ site_get_config_from_json(
                                        'pages::home_contents',
                                        'subheader',
                                        'Opening your home to vacationers is a great way to earn some extra income, and this is a great way to get started!'
                                    ) }}
                                </p>
                                <a class="btn btn-marketing rounded-pill btn-primary" href="#!">Get Started</a>
                                {{--                                <a class="btn btn-marketing rounded-pill btn-primary" href="#!">Get Started</a>--}}
                                {{--                                <a class="btn btn-link btn-marketing rounded-pill" href="#!">Learn More</a>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="svg-border-rounded text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
                         fill="currentColor">
                        <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
                    </svg>
                </div>
            </header>
            @yield('content')
            <hr class="my-0"/>
        </main>
    </div>
    <div id="layoutDefault_footer">
        <footer class="footer pt-10 pb-5 mt-auto bg-white footer-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="footer-brand">SB UI Kit Pro</div>
                        <div class="mb-3">Build better websites</div>
                        <div class="icon-list-social mb-5">
                            <a class="icon-list-social-link" href="javascript:void(0);"><i class="fab fa-instagram"></i></a><a
                                class="icon-list-social-link" href="javascript:void(0);"><i class="fab fa-facebook"></i></a><a
                                class="icon-list-social-link" href="javascript:void(0);"><i
                                    class="fab fa-github"></i></a><a class="icon-list-social-link"
                                                                     href="javascript:void(0);"><i
                                    class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                <div class="text-uppercase-expanded text-xs mb-4">Product</div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="javascript:void(0);">Landing</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Pages</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Sections</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Documentation</a></li>
                                    <li><a href="javascript:void(0);">Changelog</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                                <div class="text-uppercase-expanded text-xs mb-4">Technical</div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="javascript:void(0);">Documentation</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Changelog</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Theme Customizer</a></li>
                                    <li><a href="javascript:void(0);">UI Kit</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                                <div class="text-uppercase-expanded text-xs mb-4">Includes</div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="javascript:void(0);">Utilities</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Components</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Layouts</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Code Samples</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Products</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Affiliates</a></li>
                                    <li><a href="javascript:void(0);">Updates</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="text-uppercase-expanded text-xs mb-4">Legal</div>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="javascript:void(0);">Privacy Policy</a></li>
                                    <li class="mb-2"><a href="javascript:void(0);">Terms and Conditions</a></li>
                                    <li><a href="javascript:void(0);">License</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-5"/>
                <div class="row align-items-center">
                    <div class="col-md-6 small">Copyright &copy; Your Website 2020</div>
                    <div class="col-md-6 text-md-right small">
                        <a href="javascript:void(0);">Privacy Policy</a>
                        &middot;
                        <a href="javascript:void(0);">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="/sbui/js/scripts.js"></script>
@yield('scripts')
</body>
</html>

@include('layouts.partials.ga')

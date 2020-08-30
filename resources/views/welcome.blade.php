<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TrenchDevs</title>
    <!-- Font Awesome icons (free version)-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
            crossorigin="anonymous"></script>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/home/styles.css" rel="stylesheet">
    <link rel="icon" href="/favicon.png"/>

    <!-- Fonts CSS-->
    <link rel="stylesheet" href="css/home/heading.css">
    <link rel="stylesheet" href="css/home/body.css">

    @include('layouts.partials.ga')

</head>
<body id="page-top">
<nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
    <div class="container"><a class="navbar-brand js-scroll-trigger" href="#page-top">TRENCHDEVS</a>
        <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button"
                data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#portfolio">
                        PORTFOLIO
                    </a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#about">
                        ABOUT
                    </a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="#contact">
                        CONTACT US
                    </a>
                </li>

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{route('blogs')}}">
                        BLOG
                    </a>
                </li>

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/login">
                        SIGN IN / JOIN
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<header class="masthead bg-primary text-white text-center">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image--><img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="">
        <!-- Masthead Heading-->
        <h1 class="masthead-heading mb-0">TRENCHDEVS</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="pre-wrap masthead-subheading font-weight-light mb-0">Software Engineers</p>
        <p><small>We know how it was like to be in the trenches</small></p>
    </div>
</header>
<section class="page-section portfolio" id="portfolio">
    <div class="container">
        <!-- Portfolio Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading text-secondary mb-0 d-inline-block">PROJECTS</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Portfolio Grid Items-->
        @if ($projects)
            <div class="row justify-content-center text-center">
            @foreach($projects as $project)
                <!-- Portfolio Items-->
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal0">
                            <a href="{{ $project->project_url }}" target="_blank">
                                <div
                                    class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white">
                                        <i class="fas fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <img
                                    style="height: 200px; width: 200px; object-fit:scale-down;"
                                    class="img-fluid rounded"
                                    src="{{$project->image_url}}"
                                     alt="{{ $project->label }}"/>

                                <p class="text-center mt-3">{{$project->label}}</p>
                            </a>
                        </div>

                    </div>

                @endforeach
            </div>

        @endif
    </div>
</section>
<!-- Portfolio Modal-->

<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- About Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading d-inline-block text-white">ABOUT</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- About Section Content-->
        <div class="row">
            <div class="col-lg-4">
                <p class="text-center">
                    We are a group of individuals developers who believe in expanding our knowledge in software
                    development
                </p>
            </div>
            <div class="col-lg-4">
                <p class="text-center">We achieve this by applying it through various good cause open-source projects </p>
            </div>
            <div class="col-lg-4">
                <p class="text-center">
                    Paying back to our mentors we plan, design, implement and test software free of charge, just tell
                    us your cause and motivation for the project
                </p>
            </div>
        </div>
    </div>
</section>
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <div class="text-center">
            <h2 class="page-section-heading text-secondary d-inline-block mb-0">CONTACT US</h2>
        </div>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Content-->
        <div class="row justify-content-center">
            {{--            <div class="col-lg-4">--}}
            {{--                <div class="d-flex flex-column align-items-center">--}}
            {{--                    <div class="icon-contact mb-3"><i class="fas fa-mobile-alt"></i></div>--}}
            {{--                    <div class="text-muted">Phone</div>--}}
            {{--                    <div class="lead font-weight-bold">(555) 555-5555</div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-lg-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="icon-contact mb-3"><i class="far fa-envelope"></i></div>
                    <div class="text-muted">Email</div>
                    <a class="lead font-weight-bold" href="mailto:support@trenchdevs.org">support@trenchdevs.org</a>
                </div>
            </div>
        </div>
    </div>
</section>
<footer class="footer text-center">
    <div class="container">
        <div class="row">
            <!-- Footer Location-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="mb-4">LOCATION</h4>
                <p class="pre-wrap lead mb-0">USA & PHILIPPINES</p>
            </div>
            <!-- Footer Social Icons-->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h4 class="mb-4">AROUND THE WEB</h4>
                <a class="btn btn-outline-light btn-social mx-1" href="https://www.facebook.com/trenchdevs">
                    <i class="fab fa-fw fa-facebook-f"></i>
                </a>
                {{--                <a class="btn btn-outline-light btn-social mx-1" href="https://www.twitter.com/trenchdevs">--}}
                {{--                    <i class="fab fa-fw fa-twitter"></i>--}}
                {{--                </a>--}}
                {{--                <a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/trenchdevs">--}}
                {{--                    <i class="fab fa-fw fa-linkedin-in"></i>--}}
                {{--                </a>--}}
            </div>
            <!-- Footer About Text-->
            <div class="col-lg-4">
                <h4 class="mb-4">ABOUT TRENCHDEVS</h4>
                <p class="pre-wrap lead mb-0">We know how it was like to be in the trenches</p>
            </div>
        </div>
    </div>
</footer>
<!-- Copyright Section-->
<section class="copyright py-4 text-center text-white">
    <div class="container"><small class="pre-wrap">Copyright © TrenchDevs {{date('Y')}}</small></div>
</section>
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
<div class="scroll-to-top d-lg-none position-fixed"><a class="js-scroll-trigger d-block text-center text-white rounded"
                                                       href="#page-top"><i class="fa fa-chevron-up"></i></a></div>
<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Contact form JS-->
<!-- Core theme JS-->
<script src="js/home-scripts.js"></script>
</body>
</html>

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
    <link href="/css/home/styles.css" rel="stylesheet">
    <link rel="icon" href="/favicon.png"/>

    <!-- Fonts CSS-->
    <link rel="stylesheet" href="/css/home/heading.css">
    <link rel="stylesheet" href="/css/home/body.css">

    <style>
        .card-header {
            background-color: #1f2d41;
            color: white !important;
        }
    </style>

    @include('layouts.partials.ga')

</head>
<body id="page-top">
<nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
    <div class="container"><a class="navbar-brand js-scroll-trigger" href="{{route('public.home')}}">TRENCHDEVS</a>
        <button class="navbar-toggler navbar-toggler-right font-weight-bold bg-primary text-white rounded" type="button"
                data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{route('public.home')}}#portfolio">
                        PROJECTS
                    </a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{route('public.home')}}#about">
                        ABOUT
                    </a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{route('public.home')}}#contact">
                        CONTACT US
                    </a>
                </li>

                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="{{route('blogs')}}">
                        BLOG
                    </a>
                </li>

                @if($loggedInUser)
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/login">
                            PORTAL
                        </a>
                    </li>
                @else
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" href="/login">
                            SIGN IN / JOIN
                        </a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Copyright Section-->
<section class="copyright py-4 text-center text-white">
    <div class="container">
        <small class="pre-wrap">
            <a href="{{route('public.home')}}">Copyright © TrenchDevs {{date('Y')}}</a>
        </small>
    </div>
    <div class="container">
        <a href="{{route('documents.privacy')}}">Privacy Policy</a> &middot; <a href="{{route('documents.tnc')}}">Terms and Conditions</a>
    </div>
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
<script src="/js/home-scripts.js"></script>
</body>
</html>

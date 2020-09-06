@php
    /** @var \App\User $user */
    /** @var \App\Models\Users\UserPortfolioDetail $portfolio_details */
@endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>{{ $user->name()  }} - {{env('APP_NAME')}}</title>
    <link rel="icon" href="/favicon.png"/>
    <link href="/portfolio/css/styles.css" rel="stylesheet"/>
@include('layouts.partials.ga')
<!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:500,700" rel="stylesheet"
          type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Muli:400,400i,800,800i" rel="stylesheet" type="text/css"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="/portfolio/custom/basic/css/styles.css" rel="stylesheet"/>

    <style>
        .bg-primary {
            background-color: #2c3e50 !important;
        }

        .text-primary {
            color: #1abc9c !important;
        }

        a {
            color: #1abc9c !important;
        }

        a:hover {
            color: white !important;
            background-color: #2c3e50 !important;
        }

        #email:hover {
            color: black !important;
            background-color: white !important;
        }

        nav {
            color: black !important;
        }

    </style>
</head>
<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <span class="d-block d-lg-none">{{$user->name()}}</span>
        <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2"
                                             src="{{$user->avatar_url ?? ''}}" alt=""/></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
            class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#experience">Experience</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#education">Education</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#skills">Skills</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#interests">Interests</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#awards">Certifications</a></li>
        </ul>
    </div>
</nav>
<!-- Page Content-->
<div class="container-fluid p-0">
    <!-- About-->
    <section class="resume-section" id="about">
        <div class="resume-section-content">
            <h1 class="mb-0">
                {{$user->first_name}}
                <span class="text-primary">{{ $user->last_name }}</span>
            </h1>
            <div class="subheading mb-5">
                {{$portfolio_details->primary_phone ?? ''}} ·
                <a href="{{$user->email}}" id="email">{{$user->email}}</a>
            </div>
            <p class="lead mb-5">{{$portfolio_details->tagline}}</p>
            <div class="social-icons">
                <a class="social-icon" href="{{$portfolio_details->linkedin_url}}" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a class="social-icon" href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </section>
    <hr class="m-0"/>
    <!-- Experience-->
    <section class="resume-section" id="experience">
        <div class="resume-section-content">
            <h2 class="mb-5">Experience</h2>
            @foreach($user->experiences as $experience)
                <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{$experience->title}}</h3>
                        <div class="subheading mb-3">{{$experience->company}}</div>
                        <p>{!! $experience->description !!}</p>
                    </div>

                    <div class="flex-shrink-0">
                    <span class="text-primary">{{ date('F Y', strtotime($experience->start_date)) }} -
                    {{ $experience->end_date ? date('F Y', strtotime($experience->end_date)) : 'PRESENT' }}
                    </span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <hr class="m-0"/>
    <!-- Education-->
    <section class="resume-section" id="education">
        <div class="resume-section-content">
            <h2 class="mb-5">Education</h2>
            @foreach($user->degrees as $degree)
                <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{$degree->educational_institution}}</h3>
                        <div class="subheading mb-3">{{$degree->degree}}</div>
                        {{--                    <div>Computer Science - Web Development Track</div>--}}
                        {{--                    <p>GPA: 3.23</p>--}}
                    </div>
                    <div class="flex-shrink-0">
                    <span class="text-primary">
                        {{ date('F Y', strtotime($degree->start_date)) }} -
                    {{ $degree->end_date ? date('F Y', strtotime($degree->end_date)) : 'PRESENT' }}
                    </span>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
    <hr class="m-0"/>
    <!-- Skills-->
    <section class="resume-section" id="skills">
        <div class="resume-section-content">
            <h2 class="mb-5">Skills</h2>
            <div class="subheading mb-3">Fluent</div>
            {!! $user->skills->fluent ?? '' !!}
            <div class="subheading mb-3">Conversationally Fluent</div>
            {!! $user->skills->conversatinally_fleunt ?? '' !!}
            <div class="subheading mb-3"></div>
            {!! $user->skills->tourist ?? '' !!}
        </div>
    </section>
    <hr class="m-0"/>
    <!-- Interests-->
    <section class="resume-section" id="interests">
        <div class="resume-section-content">
            <h2 class="mb-5">Interests</h2>
            {{ $portfolio_details->interests }}
        </div>
    </section>
    <hr class="m-0"/>
    <!-- Awards-->
    <section class="resume-section" id="awards">
        <div class="resume-section-content">
            <h2 class="mb-5">Awards & Certifications</h2>
            <ul class="fa-ul mb-0">
                @foreach($user->certifications as $certification)
                    <li>
                        <a href="{{ $certification->certification_url }}">
                            <span class="fa-li"><i class="fas fa-trophy text-warning"></i></span>
                            <strong>{{$certification->title}}</strong> - {{$certification->issuer}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Core theme JS-->
<script src="/portfolio/custom/basic/js/scripts.js"></script>
</body>
</html>

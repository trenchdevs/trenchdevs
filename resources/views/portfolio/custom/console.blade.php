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
    @include('layouts.partials.ga')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@200&display=swap" rel="stylesheet">

    <!-- CSS Reset -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <style>
        body {
            font-family: 'Roboto Mono', monospace !important;
            color: black;
            max-width: 1028px;
            margin: 0 auto;
        }

    </style>

</head>
<body id="page-top p-3">

<!-- Page Content-->
<div class="container-fluid p-5 pt-0">

    <!-- Navigation-->
    <nav>
        <ul class="mt-3 list-unstyled d-flex justify-content-center flex-wrap">
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#skills">Skills</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#experience">Experience</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#education">Education</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#projects">Proejcts</a></li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#awards">Certifications</a></li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="{{route('public.blogs')}}?username={{$user->username}}">
                    Blogs
                </a>
            </li>
            <li class="nav-item"><a class="nav-link js-scroll-trigger" href="{{get_site_url()}}">TrenchDevs</a></li>
        </ul>
    </nav>

    <hr class="mb-5">

    <!-- About-->
    <section class="resume-section" id="about">
        <div class="resume-section-content">
            <img class="img-fluid rounded-circle mx-auto w-25 d-block" src="{{$user->avatar_url ?? ''}}"
                 alt="Profile Photo"/>

            <h1 class="mb-0 text-center mt-3">
                {{$user->first_name}}
                <span>{{ $user->last_name }}</span>
            </h1>
            <div class="subheading mb-3 text-center">
                {{$portfolio_details->primary_phone ?? ''}} ·
                <a href="mailto:{{$user->email}}" id="email" target="_blank">{{$user->email}}</a> ·
            </div>

            <p class="lead mb-3">
                {{$portfolio_details->tagline}}
            </p>

            <p class="d-flex align-items-start justify-content-end">
                <a href="//{{$portfolio_details->linkedin_url}}" target="_blank">
                    <i data-feather="linkedin"></i>
                </a> ·
                <a href="//{{$portfolio_details->github_url}}" target="_blank">
                    <i data-feather="github"></i>
                </a>
            </p>

        </div>
    </section>

    <!-- Skills-->
    <section class="resume-section mt-5" id="skills">
        <div class="resume-section-content">

            <div class="row">
                <div class="col">
                    <h2 class="mb-5">Skills</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="subheading mb-4">Fluent</div>
                    {!! $user->skills->fluent ?? '' !!}
                </div>
                <div class="col-md-4">
                    <div class="subheading mb-4">Conversationally Fluent</div>
                    {!! $user->skills->conversationally_fluent ?? '' !!}
                </div>
                <div class="col-md-4">
                    <div class="subheading mb-4">Tourist</div>
                    {!! $user->skills->tourist ?? '' !!}
                </div>
            </div>
        </div>
    </section>

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

    <!-- Projects -->
    <section class="projects-section mb-5" id="projects">

        <h2 class="mb-5">Projects</h2>
        <div class="row d-flex justify-content-center flex-wrap align-items-center h-100 w-100">
            @foreach($user->projects()->orderBy('id', 'desc')->get() as $project)
                <div class="col-sm-6 col-md-4 col-xs-6  text-center p-5">
                    <img class="img-fluid " src="{{$project->image_url}}" alt="{{$project->title}}">
                    <div class="mt-5">{{$project->title}}</div>
                </div>
            @endforeach
        </div>

    </section>


    <!-- Awards-->
    <section class="resume-section mb-5" id="awards">
        <div class="resume-section-content">
            <h2 class="mb-5">Certifications</h2>
            <ul class="list-unstyled mb-0">
                @foreach($user->certifications as $certification)
                    <li>
                        <a class="page-link" href="{{ $certification->certification_url }}" target="_blank">
                            <span class="fa-li"><i data-feather="award"></i></span>
                            <strong>{{$certification->title}}</strong> - {{$certification->issuer}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- Education-->
    <section class="resume-section" id="education">
        <div class="resume-section-content">
            <h2 class="mb-5">Education</h2>
            @foreach($user->degrees as $degree)
                <div class="d-flex flex-column flex-md-row justify-content-between mb-5">
                    <div class="flex-grow-1">
                        <h3 class="mb-0">{{$degree->educational_institution}}</h3>
                        <div class="subheading mb-3">{{$degree->degree}}</div>
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

    <hr>

    <div class="row">
        <nav class="col-md-6">
            <ul class="mt-3 list-unstyled ">
                <li class="nav-item"><a class=" js-scroll-trigger" href="#about">About</a></li>
                <li class="nav-item"><a class=" js-scroll-trigger" href="#skills">Skills</a></li>
                <li class="nav-item"><a class=" js-scroll-trigger" href="#experience">Experience</a></li>
                <li class="nav-item"><a class=" js-scroll-trigger" href="#education">Education</a></li>
                <li class="nav-item"><a class=" js-scroll-trigger" href="#projects">Projects</a></li>
                <li class="nav-item"><a class=" js-scroll-trigger" href="#awards">Certifications</a></li>
            </ul>
        </nav>
        <nav class="col-md-6">
            <ul class="mt-3 list-unstyled ">

                <li class="nav-item"><a class=" js-scroll-trigger"
                                        href="{{route('public.blogs')}}?username={{$user->username}}">Blogs</a></li>
                <li class="nav-item"><a class="js-scroll-trigger" href="{{get_site_url()}}">TrenchDevs</a></li>
            </ul>
        </nav>
    </div>

</div>

<script>
    feather.replace()
</script>
</body>
</html>

@php
    /** @var \App\User $user */
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
            <header class="page-header page-header-dark bg-img-cover overlay overlay-60"
                    style='background-image: url("{{empty($portfolio_details->background_cover_url) ? 'https://source.unsplash.com/6dW3xyQvcYE/1600x1200' : $portfolio_details->background_cover_url}}")'>
                <div class="page-header-content py-15">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-8">
                                <h1 class="page-header-title">{{ $user->name() }}</h1>
                                <p class="page-header-text mb-5">
                                    {{$portfolio_details->tagline}}
                                </p>
                                <a class="btn btn-marketing rounded-pill btn-blue lift lift-sm"
                                   target="_blank"
                                   href="//{{ $portfolio_details->linkedin_url }}"
                                   target="_blank"
                                >
                                    <i data-feather="github"></i>
                                    Linkedin
                                </a>
                                <a class="btn btn-marketing rounded-pill btn-white lift lift-sm"
                                   target="_blank"
                                   href="//{{ $portfolio_details->github_url }}"
                                   target="_blank"
                                >
                                    <i data-feather="github"></i>
                                    Github
                                </a>
                                <a class="btn btn-marketing rounded-pill btn-teal lift lift-sm"
                                   target="_blank"
                                   href="//{{ $portfolio_details->resume_url }}"
                                   target="_blank"
                                >
                                    <i class="fas fa-file-pdf mr-2"></i>
                                    Resume
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="svg-border-angled text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                         fill="currentColor">
                        <polygon points="0,100 100,0 100,100"></polygon>
                    </svg>
                </div>
            </header>
            <section class="bg-white py-10">
                <div class="container">
                    <div class="text-uppercase-expanded small mb-2">Experience</div>
                    <hr class="mt-0 mb-5"/>
                    <div class="row mb-5">
                        <div class="col-lg-8">
                            <h4 class="mb-0">Senior Sales Analyst</h4>
                            <p class="lead">Intelitec Solutions</p>
                            <p>Bring to the table win-win survival strategies to ensure proactive domination. At the end
                                of the day, going forward, a new normal that has evolved from generation X is on the
                                runway heading towards a streamlined cloud solution. User generated content in real-time
                                will have multiple touchpoints for offshoring.</p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <div class="text-gray-400 small">May 2018 - Present</div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-lg-8">
                            <h4 class="mb-0">Marketing Analyst</h4>
                            <p class="lead">Shout Media Productions</p>
                            <p>Capitalize on low hanging fruit to identify a ballpark value added activity to beta test.
                                Override the digital divide with additional clickthroughs from DevOps. Nanotechnology
                                immersion along the information highway will close the loop on focusing solely on the
                                bottom line.</p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <div class="text-gray-400 small">August 2015 - May 2018</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <h4 class="mb-0">Sales Representative</h4>
                            <p class="lead">Gamby Enterprises</p>
                            <p>Collaboratively administrate empowered markets via plug-and-play networks. Dynamically
                                procrastinate B2C users after installed base benefits. Dramatically visualize customer
                                directed convergence without revolutionary ROI.</p>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <div class="text-gray-400 small">June 2011 - August 2015</div>
                        </div>
                    </div>
                </div>
                <div class="svg-border-angled text-light">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                         fill="currentColor">
                        <polygon points="0,100 100,0 100,100"></polygon>
                    </svg>
                </div>
            </section>
            @if(!empty($user->degrees))
                <section class="bg-light py-10">
                    <div class="container">
                        <div class="text-uppercase-expanded small mb-2">Education</div>
                        <hr class="mt-0 mb-5"/>
                        @foreach($user->degrees as $degree)
                            <div class="row mb-5">
                                <div class="col-lg-8">
                                    <h4 class="mb-0">{{$degree->educational_institution}}</h4>
                                    <p class="lead">{{ $degree->degree }}</p>
                                    {!! $degree->description !!}
                                </div>
                                <div class="col-lg-4 text-lg-right">
                                    <div class="text-gray-400 small">{{ date('F Y', strtotime($degree->start_date)) }}
                                        - {{ date('F Y', strtotime($degree->end_date)) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="svg-border-angled text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                             fill="currentColor">
                            <polygon points="0,100 100,0 100,100"></polygon>
                        </svg>
                    </div>
                </section>
            @endif
            @if(!empty($user->skills))
                <section class="bg-white py-10">
                    <div class="container">
                        <div class="text-uppercase-expanded small mb-2">Skills</div>
                        <hr class="mt-0 mb-5"/>
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Fluent</strong></p>
                                {!! $user->skills->fluent !!}
                            </div>
                            <div class="col-md-4">
                                <p><strong>Conversationally Fluent</strong></p>

                                {!! $user->skills->conversationally_fluent !!}
                            </div>
                            <div class="col-md-4">
                                <p><strong>Tourist</strong></p>

                                {!! $user->skills->tourist !!}
                            </div>
                        </div>
                    </div>
                    <div class="svg-border-angled text-light">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                             fill="currentColor">
                            <polygon points="0,100 100,0 100,100"></polygon>
                        </svg>
                    </div>
                </section>
            @endif
            @if(!empty($portfolio_details->interests))

                <section class="bg-light py-10">
                    <div class="container">
                        <div class="text-uppercase-expanded small mb-2">Interests</div>
                        <hr class="mt-0 mb-5"/>
                        <div class="row">
                            <div class="col-lg-8">
                                {{$portfolio_details->interests}}
                            </div>
                        </div>
                    </div>
                    <div class="svg-border-angled text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                             fill="currentColor">
                            <polygon points="0,100 100,0 100,100"></polygon>
                        </svg>
                    </div>
                </section>
            @endif
            <section class="bg-white py-10">
                <div class="container">
                    <div class="text-uppercase-expanded small mb-2">Contact</div>
                    <hr class="mt-0 mb-5"/>
                    <div class="row">
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <h3>{{$user->name()}}</h3>
                            <p class="lead mb-0">{{$portfolio_details->primary_phone}}</p>
                            <a href="#!">{{$user->email}}</a>
                        </div>
                        <div class="col-lg-4 text-lg-right">
                            <a class="btn btn-marketing btn-teal rounded-pill" target="_blank"
                               href="//{{$portfolio_details->resume_url}}">
                                <i class="fas fa-file-pdf mr-2"></i>Download Resume
                            </a>
                        </div>
                    </div>
                </div>
                <div class="svg-border-angled text-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                         fill="currentColor">
                        <polygon points="0,100 100,0 100,100"></polygon>
                    </svg>
                </div>
            </section>
        </main>
    </div>
    <div id="layoutDefault_footer">
        <footer class="footer pt-10 pb-5 mt-auto bg-dark footer-dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="icon-list-social mb-5">
                            <a class="icon-list-social-link" target="_blank"
                               href="//{{$portfolio_details->linkedin_url}}">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a class="icon-list-social-link" target="_blank"
                               href="//{{$portfolio_details->github_url}}">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>
                    </div>

                </div>
                <hr class="my-5"/>
                <div class="row align-items-center">
                    <div class="col-md-6 small">Copyright &copy; TrenchDevs {{ date('Y') }}</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="/portfolio/js/scripts.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'TrenchDevs')  }}</title>
    <link rel="icon" href="/favicon.png"/>

    <link href="/sbui/css/styles.css" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png"/>
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"
            crossorigin="anonymous"></script>

    {{-- Overrides   --}}
    <style>
        .text-primary {
            color: #00a180 !important;
        }


        a.text-primary:hover, a.text-primary:focus {
            color: #0f6674 !important
        }

        .btn-primary {
            background-color: #00a180;
            border: none;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #0f6674 !important
        }
    </style>
</head>
<body>
<div id="layoutDefault">
    <div id="layoutDefault_content">
        <main>
            <nav class="navbar navbar-marketing navbar-expand-lg bg-dark navbar-dark">
                <div class="container">
                    <a class="navbar-brand text-primary" href="/">TrenchDevs Blog</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto mr-lg-5">
                            <li class="nav-item"><a class="nav-link" target="_blank" href="https://trenchdevs.org">TrenchDevs
                                    Home</a></li>
                        </ul>
                        <a class="btn-primary btn rounded-pill px-4 ml-lg-4" href="/register">Join<i
                                class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </nav>
            @yield('contents')
        </main>
    </div>
    <div id="layoutDefault_footer">
        <footer class="footer pt-10 pb-5 mt-auto bg-dark footer-dark">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="footer-brand">TrenchDevs Blog</div>
                        <div class="mb-3">Build better websites</div>
                        <div class="icon-list-social mb-5">
                            <a target="_blank" class="icon-list-social-link" href="https://www.facebook.com/trenchdevs"><i
                                    class="fab fa-facebook"></i></a>
                            <a target="_blank" class="icon-list-social-link" href="https://github.com/trenchdevs"><i
                                    class="fab fa-github"></i></a>
                            {{--                            <a class="icon-list-social-link" href="javascript:void(0);"><i class="fab fa-twitter"></i></a>--}}
                        </div>
                    </div>
                    <div class="col-lg-9">

                    </div>
                </div>
                <hr class="my-5"/>
                {{--                <div class="row align-items-center">--}}
                {{--                    <div class="col-md-6 small">Copyright &copy; TrenchDevs {{date('Y') }}</div>--}}
                {{--                    <div class="col-md-6 text-md-right small">--}}
                {{--                        <a href="javascript:void(0);">Privacy Policy</a>--}}
                {{--                        &middot;--}}
                {{--                        <a href="javascript:void(0);">Terms &amp; Conditions</a>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="/sbui/js/scripts.js"></script>
</body>
</html>

<html>
<head>
    <title>🌱 Bokchoy</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700|Inconsolata:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CSS only -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">

    <style>

        body {
            font-family: "Josefin Sans", sans-serif;
        }

        .bio-image {
            max-width: 120px;
            position: absolute;
            top: -65px;
            left: 0;
            right: 0;
            margin-left: auto;
            margin-right: auto;
        }

        .bio-wrapper {
            margin-top: 110px !important;
        }

        .main-header {
            font-size: 4.5em;
        }

        .badge-text {
            font-size: 0.8em;
            margin-bottom: 10px;
            padding: 8px;
        }

        body {
            background-color: #eff3fd;
        }

        .container {
            background-color: white;
        }

        .nav-links {
            color: gray !important;
        }

        .nav-links > a {
            color: #747882 !important;
        }

        .post-card-link {
            color: black;
        }

        .post-card-link:hover {
            color: black;
            text-decoration: none;
        }

        .post-card-link > .card:hover {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .page-item {
            margin: 0 5px;
            text-align: center;
        }

        .page-item > a, .page-item > span {
            border-radius: 50% !important;
            background-color: transparent;
        }

        .input-search-wrapper input, .input-search-wrapper .input-group-text {
            background-color: #61d67c;
            border: none;
            color: black;
        }

        .input-search-wrapper input:focus, .input-search-wrapper input:active {
            background-color: #61d67c;
            border: none;
            box-shadow: none;
        }

        .cursor-pointer {
            cursor: pointer;
        }


    </style>

    @yield('style')

</head>
<body>

<div class="container p-0">

    <div class="row no-gutters">
        <div class="col no-gutters">
            <nav class="navbar navbar-light bg-success pl-5">
                <h4><a href="https://twitter.com/dnmri03" target="_blank"><i
                            class="bi bi-twitter cursor-pointer text-white"></i></a></h4>
                <h4><a href="https://instagram.com/dp.espiritu" target="_blank"><i
                            class="bi bi-instagram cursor-pointer ml-2 text-white"></i></a></h4>
                <div class="input-group my-1 w-25 ml-auto input-search-wrapper">
                    {{--                    <input type="text" class="form-control" placeholder="Type a keyword to search ...">--}}
                    {{--                    <div class="input-group-append">--}}
                    {{--                        <span class="input-group-text">🔍</span>--}}
                    {{--                    </div>--}}
                </div>
            </nav>
        </div>
    </div>

    <div class="px-5">
        <div class="row mb-3">
            <div class="col-md-12  mt-5 mb-5">
                <h1 class="text-center main-header">
                    🌱 Bokchoy
                </h1>
                <h5 class="text-center"><em>(Growing Bokchoy)</em></h5>
            </div>

            <div class="col-md-12">

                <div class="nav-links text-center border-bottom pb-4 mb-5">
                    <a href="/">Home</a> •
                    <a href="{{route('public.blogs.index')}}">Blogs</a> •
                    <a href="{{route('public.pages.about')}}">About</a>
                </div>
            </div>


        </div>


        <div class="row">

            @yield('pre-content')

            <div class="col-md-6 col-lg-8 mb-5">
                @yield('content')
            </div>

            {{--  Sidebar --}}
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 px-5">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <form action="{{route('public.blogs.index')}}">
                            <div class="input-group mb-3">
                                <input type="text" name="q" class="form-control" placeholder="Search Post ..."
                                       value="{{request()->get('q')}}">
                                <div class="input-group-append cursor-pointer">
                                    <span class="input-group-text">🔍</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mb-2 border bio-wrapper">
                    <div class="col-md-12 text-center">
                        <img style="max-width: 120px" class="rounded-circle img-fluid bio-image"
                             src="https://growingbokchoy.s3.amazonaws.com/production/public/canvas/images/zrdVmPvNVZ0ZOf9rg6wOGQc8ToqzowZhjDkgfe9Q.png"
                             alt="Card image cap">
                    </div>

                    <div class="px-3 text-center mt-4 mb-3 mt-5 pb-2 py-1">
                        <h3 class="mt-3">Hey, I'm Donmari ❤️</h3>
                        <p class="text-center text-secondary">
                            I’m the mom of a vegetable, baby Bokchoy! I’m here to share my motherhood journey as a first
                            time, stay-at-home mom.
                        </p>
                    </div>

                    <div class="col-md-12 text-center mb-4 text-white">
                        <a class="btn btn-primary" href="{{route('public.pages.about')}}">
                            Read my bio
                        </a>
                    </div>
                </div>

                <div class="row">

                </div>

                {{--  Popular Posts  --}}

                <div class="row mt-5">
                    <div class="col-md-12 border-bottom mb-3 pb-3">
                        Popular Posts
                    </div>
                </div>

                Coming Soon...

                {{--                @foreach($popular_posts as $post)--}}
                {{--                    <a class="post-card-link" href="{{route('posts.slug', $post->slug ?? '')}}">--}}
                {{--                        <div class="row mb-3">--}}
                {{--                            <div class="col-md-4">--}}
                {{--                                <img class="img-fluid" src="{{$post->featured_image}}"--}}
                {{--                                     alt="{{$post->featured_image_caption}}">--}}
                {{--                            </div>--}}
                {{--                            <div class="col-md-8">--}}
                {{--                                <p><strong>{{$post->title}}</strong></p>--}}
                {{--                                <span class="text-secondary">--}}
                {{--                                {{date('F j, Y, g:i a', strtotime($post->created_at))}}--}}
                {{--                </span>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </a>--}}

                {{--                @endforeach--}}


                {{--  Topics  --}}
                {{--                <div class="row mt-5">--}}
                {{--                    <div class="col-md-12">--}}
                {{--                        <div class="border-bottom mb-3 pb-3">--}}
                {{--                            Topics--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                {{--                <div class="row mb-3">--}}
                {{--                    <div class="col-md-12">--}}
                {{--                        todo: topics--}}
                {{--                        --}}{{--                        @foreach($topics as $topic)--}}
                {{--                        --}}{{--                            <div class="mb-3 border-bottom pb-2 d-flex justify-content-between">--}}
                {{--                        --}}{{--                                <a href="{{route('topics.posts', $topic->name)}}">{{$topic->name}}</a>--}}
                {{--                        --}}{{--                                <span>({{$topic->total_posts}})</span>--}}
                {{--                        --}}{{--                            </div>--}}
                {{--                        --}}{{--                        @endforeach--}}
                {{--                    </div>--}}
                {{--                </div>--}}


                {{--  Tags  --}}

                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="border-bottom mb-3 pb-3">
                            Tags
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        @foreach($tags as $tag)
                            <a class="badge badge-primary badge-text"
                               href="{{route('public.blogs.index', ['tid'=> $tag->id])}}">{{$tag->tag_name}}</a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
        crossorigin="anonymous"></script>

@include('layouts.partials.ga')
</body>
</html>

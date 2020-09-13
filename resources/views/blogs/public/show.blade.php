@extends('layouts.blog')

@section('styles')
    <style>
        #markdown_contents img {
            width: 100%;
            text-align: center;
            padding: 2rem;
        }


        #markdown_contents h1,
        #markdown_contents h2,
        #markdown_contents h3,
        #markdown_contents h4,
        #markdown_contents h5,
        #markdown_contents h6 {
            margin-bottom: 25px;
        }

    </style>


    <link href="/blog/prism/prism.css" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="/blog/prism/prism.js"></script>
@endsection

@section('contents')

    @php /** @var \App\Models\Blog $blog */ @endphp

    <section class="bg-light py-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="single-post">
                        <h1>{{$blog->title}}</h1>
                        <p class="lead">{{$blog->tagline}}</p>
                        <div class="d-flex align-items-center justify-content-between mb-5">
                            <div class="single-post-meta mr-4">
                                <img class="single-post-meta-img"
                                     src="{{ empty($blog->user->avatar_url) ? 'https://source.unsplash.com/300x300/?user' : $blog->user->avatar_url  }}"/>
                                <div class="single-post-meta-details">
                                    <div class="single-post-meta-details-name">
                                        <a target="_blank"
                                           href="{{$blog->user->getPortfolioUrl()}}">{{$blog->user->name()}}</a>
                                    </div>
                                    <div class="single-post-meta-details-date">{{$blog->getDateMeta()}}</div>
                                </div>
                            </div>
                            <div class="single-post-meta-links">
                                <a href="https://twitter.com/intent/tweet?text={{$blog->title}}%20via%20{{request()->fullUrl()}}">
                                    <i class="fab fa-twitter fa-fw"></i>
                                </a>
                                <a target="_blank"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{request()->fullUrl()}}">
                                    <i class="fab fa-facebook-f fa-fw"></i></a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{request()->fullUrl()}}&title={{$blog->title}}&summary={{$blog->tagline}}&source={{request()->url()}}">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>
                        <img class="img-fluid mb-2" src="{{$blog->primary_image_url}}"/>
                        <div class="mt-3" id="markdown_contents">
                            {!! $blog->markdownContentsAsHtml() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
                 fill="currentColor">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>

@endsection

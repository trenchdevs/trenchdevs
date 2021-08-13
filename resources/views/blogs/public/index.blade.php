@extends('layouts.blog')

@section('contents')

    <header class="page-header page-header-dark bg-img-cover overlay overlay-60"
            style="background-image: url(https://images.unsplash.com/photo-1572966901946-e5c9ac18c283?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&ixid=eyJhcHBfaWQiOjF9&ixlib=rb-1.2.1&q=80&w=1600);">
        <div class="page-header-content">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h1 class="page-header-title mb-3">Publications</h1>
                        <p class="page-header-text mb-0" style="color: white !important;">Browse articles, keep up to
                            date, and learn more on our
                            blog!
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-light">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
                 fill="currentColor">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </header>
    <section class="bg-light py-10">
        <div class="container">
            {{--                    <a class="card post-preview post-preview-featured lift mb-5" href="#!"--}}
            {{--                    ><div class="row no-gutters">--}}
            {{--                            <div class="col-lg-5"><div class="post-preview-featured-img" style='background-image: url("https://source.unsplash.com/vZJdYl5JVXY/660x360")'></div></div>--}}
            {{--                            <div class="col-lg-7">--}}
            {{--                                <div class="card-body">--}}
            {{--                                    <div class="py-5">--}}
            {{--                                        <h5 class="card-title">Boots on the Ground, Inclusive Thought Provoking Ideas</h5>--}}
            {{--                                        <p class="card-text">Empower communities and energize engaging ideas; scale and impact do-gooders while disruptring industries. Venture philanthropy benefits corporations and people by moving the needle.</p>--}}
            {{--                                    </div>--}}
            {{--                                    <hr />--}}
            {{--                                    <div class="post-preview-meta">--}}
            {{--                                        <img class="post-preview-meta-img" src="https://source.unsplash.com/QAB-WJcbgJk/100x100" />--}}
            {{--                                        <div class="post-preview-meta-details">--}}
            {{--                                            <div class="post-preview-meta-details-name">Valerie Luna</div>--}}
            {{--                                            <div class="post-preview-meta-details-date">Feb 5 &middot; 6 min read</div>--}}
            {{--                                        </div>--}}
            {{--                                    </div>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </div></a--}}
            {{--                    >--}}

            <div class="row">

                @foreach($blogs as $blog)

                    @php /** @var \App\Domains\Blogs\Models\Blog $blog */ @endphp
                    <div class="col-md-6 col-xl-4 mb-5">
                        <a class="card post-preview lift h-100" href="/{{$blog->slug}}?user={{$blog->user->username}}">
                            <img class="card-img-top"
                                 src="{{!empty($blog->primary_image_url) ? $blog->primary_image_url : 'https://source.unsplash.com/1024x760/?blog,blogs,book'}}"
                                 alt="..."/>
                            <div class="card-body">
                                <h5 class="card-title">{{$blog->title}}</h5>
                                <p class="card-text">{{$blog->tagline}}</p>
                            </div>
                            <div class="card-footer">
                                <div class="post-preview-meta">
                                    <img class="post-preview-meta-img"
                                         src="{{ empty($blog->user->avatar_url) ? 'https://source.unsplash.com/300x300/?user' : $blog->user->avatar_url  }}"/>
                                    <div class="post-preview-meta-details">
                                        <div class="post-preview-meta-details-name">{{$blog->user->name()}}</div>
                                        <div class="post-preview-meta-details-date">
                                            {{$blog->getDateMeta()}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                @endforeach
            </div>

            <nav aria-label="Page navigation example">
                {{$blogs->links()}}
            </nav>

        </div>
        <div class="svg-border-rounded text-dark">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none"
                 fill="currentColor">
                <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
            </svg>
        </div>
    </section>



@endsection

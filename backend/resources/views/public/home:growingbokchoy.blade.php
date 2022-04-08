@extends('layouts.themes.growingbokchoy')

@section('style')

@endsection

@section('pre-content')

    <div class="col-md-12 mb-5">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://growingbokchoy.s3.amazonaws.com/assets/getaway.jpg " class="d-block w-100 home-banner" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://growingbokchoy.s3.amazonaws.com/assets/knowledge.jpg" class="d-block w-100 home-banner" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://growingbokchoy.s3.amazonaws.com/assets/ruby-falls.jpg" class="d-block w-100 home-banner" alt="...">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
               data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
               data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4">Latest Posts</h2>
        </div>
    </div>

    <div class="row">
        @include('public.blogs.partials.blog-cards:growingbokchoy')
    </div>

    <div class="row">
        <div class="col d-flex justify-content-center">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection

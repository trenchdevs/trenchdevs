@extends('layouts.themes.growingbokchoy')

@section('content')

    @if(!empty($tag))
        <div class="row">
            <div class="col">
                <h2 class="border-bottom">"{{$tag->tag_name}}"</h2>
            </div>
        </div>
    @endif
    <div class="row mt-3">
        @include('public.blogs.partials.blog-cards:growingbokchoy')
    </div>

    {{$blogs->links()}}

@endsection

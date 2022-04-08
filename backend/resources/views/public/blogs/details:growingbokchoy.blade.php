@extends('layouts.themes.growingbokchoy')

@section('style')

    <style>
        .post-body img {
            width: 100%;
        }

        .embedded_image p {
            font-style: italic;
            text-align: center;
        }
    </style>

@endsection

@section('content')

    <div class="row">
        <div class="col">
            <img src="{{$blog->primary_image_url}}" alt="{{$blog->tagline}}" class="img-fluid">
        </div>
    </div>

    <div class="row mt-5">
        <div class="col text-secondary">
            <img style="max-width: 30px" src="{{$blog->user->avatar ?: 'https://growingbokchoy.s3.amazonaws.com/production/public/canvas/images/zrdVmPvNVZ0ZOf9rg6wOGQc8ToqzowZhjDkgfe9Q.png'}}"
                 alt="Author avatar"
                 class="img-fluid rounded-circle"> •
            <span>{{$blog->user->name}}</span> •
            <span>{{$blog->getHumanizedDiff()}}</span>
            <span></span>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">

            <div class="mb-4">
                <h2>Mom of a Bokchoy</h2>
            </div>

            <div class="mb-4">
{{--                @foreach($post->tags as $tag)--}}
{{--                    <x-tag-badge--}}
{{--                        text="{{$tag->name}}"--}}
{{--                        href="{{route('tags.posts', $tag->slug)}}"--}}
{{--                    />--}}
{{--                @endforeach--}}
            </div>

            <div class="post-body">
                {!! $blog->markdownContentsAsHtml() !!}
            </div>

{{--            <div>--}}
{{--                Topics:--}}
{{--                @if($post->topic->isEmpty())--}}
{{--                    N/A--}}
{{--                @else--}}
{{--                    @foreach($post->topic as $topic)--}}
{{--                        <a href="{{route('topics.posts', $topic->slug)}}">{{$topic->name}}</a>--}}
{{--                    @endforeach--}}
{{--                @endif--}}

{{--            </div>--}}

        </div>
    </div>


@endsection

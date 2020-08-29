@extends('layouts.admin')

@section('page-header', 'Blogs')

@section('content')

    <div class="row mb-2">
        <div class="col text-right">
            <a href="{{route('blogs.upsert')}}" class="btn btn-success btn-sm">
                <i data-feather="feather" class="mr-2"></i>
                Create
            </a>
        </div>
    </div>

    <div class="row">
        @foreach($blogs as $blog)
            <div class="col-md-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <span>{{$blog->title}} ({{$blog->slug}})</span>
                    </div>
                    <div class="card-body">
                        <a class="btn btn-sm btn-danger float-right" href="{{route('blogs.upsert', $blog->id)}}">
                            <i data-feather="archive"></i>
                        </a>
                        <a class="btn btn-sm btn-info float-right mr-2" href="{{route('blogs.upsert', $blog->id)}}">
                            <i data-feather="edit"></i>
                        </a>

                        <p>Tagline: <strong>{{$blog->tagline}}</strong></p>
                        <p>Contents:</p>
                        {!!  Markdown::convertToHtml($blog->markdown_contents)!!}
                    </div>
                </div>
            </div>
        @endforeach

        {{ $blogs->links() }}
    </div>

@endsection


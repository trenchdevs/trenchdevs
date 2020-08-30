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
            @php /** @var \App\Models\Blog $blog */ @endphp
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

                        <p>
                            <strong>Tagline:</strong> {{$blog->tagline}}
                        </p>
                        <p>
                            <strong>Status:</strong>
                            @if($blog->status === 'published')
                                <span class="badge badge-success">PUBLISHED</span>
                            @elseif($blog->status === 'draft')
                                <span class="badge badge-warning">DRAFT</span>
                            @endif
                        </p>
                        @if($blog->status === 'published')
                            <p>
                                <strong>URL: </strong><a target="_blank" href="{{$blog->getUrl()}}">{{$blog->getUrl()}}</a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{ $blogs->links() }}
    </div>

@endsection


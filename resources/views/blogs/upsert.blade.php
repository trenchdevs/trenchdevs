@extends('layouts.admin')

@section('page-header', 'Blogs')

@section('content')

    <div class="card">
        <div class="card-header">{{!empty($blog->id) ? 'Update' : 'Create'}} Blog</div>
        <div class="card-body">

            <div>
                @include('admin.shared.errors')
            </div>


            <form action="{{route('blogs.store')}}" method="post">
                @csrf

                @if(!empty($blog->id))
                    <input type="hidden" name="id" value="{{$blog->id}}">
                @endif

                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" class="form-control" type="text" name="title"
                           value="{{ old('title', $blog->title ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input id="slug" class="form-control" type="text" name="slug"
                           value="{{ old('slug', $blog->slug ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="tagline">Tagline</label>
                    <textarea name="tagline" id="tagline" cols="30" rows="2"
                              class="form-control">{{old('tagline', $blog->tagline ?? '')}}</textarea>
                </div>

                <div class="form-group">
                    <label for="markdown_contents">Markdown Contents</label>
                    <textarea name="markdown_contents" id="markdown_contents" cols="30" rows="30"
                    >{{old('markdown_contents', $blog->markdown_contents ?? '')}}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option
                            value="draft" {{old('status', $blog->status ?? '') === 'draft' ? 'selected' : ''}}>Draft
                        </option>
                        <option
                            value="published" {{old('status', $blog->status ?? '') === 'published' ? 'selected' : ''}}>
                            Published
                        </option>
                    </select>
                </div>

                <div>
                    <input type="submit" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <script>
        var simplemde = new SimpleMDE({element: document.getElementById("markdown_contents")});
    </script>
@endsection

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
                    <input readonly id="slug" class="form-control" type="text" name="slug"
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
                    <label for="primary_image_url">
                        Primary Image URL <small>(shown on the blog listing and below title and tagline on blog
                            details)
                        </small>
                    </label>
                    <p>Tip: you can try using the unsplash to get free images <br> (eg.
                        <strong>https://source.unsplash.com/1024x760/?blog,blogs,book</strong> - This will return a url
                        to get pictures with blog / books tagged in
                        them)
                    </p>
                    <input type="text" name="primary_image_url" id="primary_image_url" class="form-control"
                           value="{{old('primary_image_url', $blog->primary_image_url ?? '')}}"
                    >

                </div>

                <div class="form-group">
                    <label for="publication_date">
                        Publication Date (when will the blog post be available to the public)
                    </label>
                    <input type="text" name="publication_date"
                           class="form-control" placeholder="YYYY-mm-dd HH:mm:ss"
                           value="{{old('publication_date', $blog->publication_date ?? '')}}">
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
        $(document).ready(function () {

            var simplemde = new SimpleMDE({element: document.getElementById("markdown_contents")});

            $("#title").on('keyup', function () {

                var titleStr = $(this).val();

                if (titleStr) {
                    var slug = titleStr.toLocaleLowerCase().split(' ').join('-');
                    slug = slug.replace(/[^0-9a-z\-]/gi, '');
                    $('#slug').val(slug);
                } else {
                    $('#slug').val('');
                }
            });
        });
    </script>
@endsection

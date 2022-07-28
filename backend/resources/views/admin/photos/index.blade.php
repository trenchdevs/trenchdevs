@extends('layouts.admin')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Upload
        </div>

        <div class="card-body p-3">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled mb-0">
                        @foreach($errors->all() as $error)
                            <span>{{$error}}</span>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col content d-flex p-4">
                    <form method="POST" action="{{route('admin.photos.upload')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="bulkUpload">Upload multiple photos</label>
                            <input
                                type="file"
                                class="form-control-file"
                                multiple
                                id="files-input"
                                accept="image/jpeg, image/png"
                                name="images[]"
                            />
                        </div>

                        <button type="submit" class="btn btn-primary btn-md" style="cursor: pointer;">
                            Upload
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Available Photos
        </div>

        <div class="card-body p-3">
            <div class="row justify-content-between mt-4">
                @if (!isset($photos) || !$photos)
                    No photos available...
                @else
                    @foreach($photos as $photo)
                        <div class="col-2 mb-2 ">
                            <span title=" {{$photo->original_filename}}">
                                {{\Illuminate\Support\Str::limit($photo->original_filename, 16, '...')}}
                            </span>
                            <button class="btn btn-success btn-sm ml-auto float-right mx-2 copy-url-button"
                                    data-url="{{$photo->image_url}}">
                                <i data-feather="copy"></i>
                            </button>
                            <form action="{{route('admin.photos.delete', $photo->id)}}" class="d-inline" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm ml-auto float-right mx-2 delete-btn" type="submit">
                                    <i data-feather="trash"></i>
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <img
                                    class="img-thumbnail img-fluid"
                                    src="{{$photo->image_url}}"
                                    alt="{{$photo->id}}"
                                >
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function () {
            $('.copy-url-button').click(function () {
                /* Copy the text inside the text field */
                navigator.clipboard.writeText($(this).data('url'));
                alert("Image URL copied to clipboard.");
            });

            $('.delete-btn').click(function () {
                return confirm('Are you sure you want to delete this photo?');
            })
        });
    </script>
@endsection

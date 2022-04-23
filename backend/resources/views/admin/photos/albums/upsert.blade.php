@extends('layouts.admin')

@section('styles')

    <style>

        form.border {
            border-radius: 15px;
        }
    </style>
@endsection

@section('content')


    @if ($album->id)
        <div class="card mb-4">
            <div class="card-header">
                Assign Photos
            </div>

            <div class="card-body p-5">

                <div class="row">
                    <p>Select photos to be added to the album on the left column</p>
                </div>

                <div class="row justify-content-between mt-4">
                    <div class="col-md-6">
                        <form action="{{ route('admin.photos.albums.associate') }}" method="POST"
                              class="text-right row border p-3 mx-3" style="min-height: 300px">
                            <input type="hidden" name="album_id" value="{{$album->id}}">
                            @if ($photos_available->isEmpty())
                                No photos available...
                            @else
                                <div class="col-12">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Add Photos</button>
                                </div>
                                @foreach($photos_available as $photo)
                                    <div class="col-2 mb-2">
                                        {{--                            <form action="{{route('admin.photos.delete', $photo->id)}}" class="d-inline" method="POST">--}}
                                        {{--                                @csrf--}}
                                        {{--                                <button class="btn btn-danger btn-sm ml-auto float-right mx-2 delete-btn" type="submit">--}}
                                        {{--                                    <i data-feather="trash"></i>--}}
                                        {{--                                </button>--}}
                                        {{--                            </form>--}}
                                        {{--                                    <hr>--}}
                                        <div class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{$photo->id}}">
                                            <img
                                                class="img-thumbnail img-fluid"
                                                src="{{$photo->image_url}}"
                                                alt="{{$photo->id}}"
                                            >
                                        </div>
                                    </div>
                                @endforeach


                            @endif
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.photos.albums.disassociate') }}" method="POST"
                              class="text-right row border p-3 mx-3" style="min-height: 300px">
                            <input type="hidden" name="album_id" value="{{$album->id}}">
                            @if ($photos_assigned->isEmpty())
                                No photos available...
                            @else
                                <div class="col-12">
                                    @csrf
                                    <button class="btn btn-danger btn-sm float-right">Remove Photos</button>
                                </div>
                                @foreach($photos_assigned as $photo)
                                    <div class="col-2 mb-2">
                                        <div class="text-center">
                                            <input type="checkbox" name="ids[]" value="{{$photo->id}}">
                                            <img
                                                class="img-thumbnail img-fluid"
                                                src="{{$photo->image_url}}"
                                                alt="{{$photo->id}}"
                                            >
                                        </div>
                                    </div>
                                @endforeach

                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="card mb-4">
        <div class="card-header">
            {{ ($album->id ?? false) ?  "Edit" : "Create" }} Album
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
                    <form method="POST" action="{{route('admin.photos.albums.post_upsert')}}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            @if(isset($album->id))
                                <input type="hidden" name="id" value="{{$album->id}}">
                            @endif

                            <div class="form-group col-12">
                                <label for="first-name">Album Name</label>
                                <input class="form-control" name="name" type="text"
                                       value="{{old('name', $album->name ?: '')}}">
                            </div>

                            <div class="form-group col-12">
                                <label for="first-name">Description</label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    type="text">{{ old('description', $album->description ?: '') }} </textarea>
                            </div>

                            <div class="form-group col-12">
                                <label for="first-name">Is Featured?</label>
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="first-name">Listing Order</label>
                                <input class="form-control" type="number" name="listing_order"
                                       value="{{ old('listing_order', $album->listing_order ?: '') }}">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-md" style="cursor: pointer;">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

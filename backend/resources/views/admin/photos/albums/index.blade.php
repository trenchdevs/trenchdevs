@extends('layouts.admin')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Albums
        </div>
        <div class="card-body table-responsive">

            <div class="row pb-3">
                <div class="col text-right">
                    <a href="{{ route('admin.photos.albums.upsert') }}" class="btn btn-sm btn-success">
                        <i data-feather="plus"></i>
                        <span class="ml-1">Create Album</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Is Featured?</th>
                            <th>Listing Order</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($albums as $album)
                            <tr>
                                <td>{{$album->name}} </td>
                                <td>{{$album->description}} </td>
                                <td>{{$album->is_featured == 1 ? "Yes" : "No"}} </td>
                                <td>{{$album->listing_order}} </td>
                                <td>{{$album->created_at}} </td>
                                <td>
                                    <a href="{{ route('admin.photos.albums.upsert', $album->id) }}" class="btn btn-sm btn-warning">
                                        <i data-feather="eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    {{ $albums->links() }}
                </div>
            </div>
        </div>

    </div>


@endsection

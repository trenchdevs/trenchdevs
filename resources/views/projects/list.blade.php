@extends('layouts.admin')

@section('page-header', 'Announcements')

@section('content')


    <div class="card mb-4">
        <div class="card-header">
            Projects

        </div>
        <div class="card-body">

            <div class="row">
                <div class="col text-right pb-3">
{{--                    <a class="btn btn-sm btn-success" href="{{route('projects.create')}}">Create</a>--}}
                </div>
            </div>

            <div class="row">
                <div class="col table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>URL</th>
                            <th>Repository URL</th>
                            <th>Image URL</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{$project->id}}</td>
                                <td>{{$project->is_personal ? "Personal" : "Global" }}</td>
                                <td>{{$project->title}}</td>
                                <td>
                                    @if(!empty($project->url))
                                        <a href="{{$project->url}}" target="_blank">Link</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($project->image_url))
                                        <a href="{{$project->image_url}}" target="_blank">Link</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($project->repository_url))
                                        <a href="{{$project->project_url}}" target="_blank">Link</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>Action</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    {{ $projects->links() }}
                </div>
            </div>
        </div>

    </div>


@endsection

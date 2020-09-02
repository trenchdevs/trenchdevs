@extends('layouts.admin')

@section('page-header', 'Announcements')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Announcements


        </div>
        <div class="card-body">

            <div class="row">
                <div class="col text-right pb-3">
                    <a class="btn btn-sm btn-success" href="{{route('announcements.create')}}">Create</a>
                </div>
            </div>

            <div class="row">
                <div class="col table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Message</th>
                            <th>Create Notifications</th>
                            <th>Send Emails</th>
                            <th>Error Message</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($announcements as $announcement)
                            <tr>
                                <td>{{$announcement->id}}</td>
                                <td>{{$announcement->title}}</td>
                                <td>{{$announcement->status}}</td>
                                <td>{{substr($announcement->message, 0, 6)}}...</td>
                                <td>{{!!$announcement->create_notifications ? "Yes": "No"}}</td>
                                <td>{{!!$announcement->send_email ? "Yes": "No"}}</td>
                                <td>{{$announcement->error_message}}</td>
                                <td>{{$announcement->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>

    </div>


@endsection

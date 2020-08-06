@extends('layouts.admin')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Users
        </div>
        <div class="card-body">
            <table class="table table-hover table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is Active</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->first_name}} {{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{!!$user->is_active ? "Yes": "No"}}</td>
                        <td>{{$user->created_at}}</td>
                        <td>
                            <a href="" class="btn btn-sm btn-primary">
                                <i data-feather="eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user->id, '') }}" class="btn btn-sm btn-warning">
                                <i data-feather="edit"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-danger">
                                <i data-feather="trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $users->links() }}
        </div>

    </div>


@endsection

@extends('layouts.admin')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Users
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
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
                            <a href="{{ route('users.edit', $user->id, '') }}" class="btn btn-sm btn-warning">
                                <i data-feather="eye"></i>
                            </a>
                            <form
                                class="d-inline" action="{{ route('users.password_reset') }}" method="post"
                                onsubmit="return confirm('Are you sure you want to send a password reset link to {{$user->email}}?');">
                                @csrf
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <button class="btn btn-sm btn-indigo" type="submit">
                                    <i data-feather="key"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            {{ $users->links() }}
        </div>

    </div>


@endsection

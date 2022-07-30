@extends('layouts.admin')

@section('content')

    <div class="card mb-4">
        <div class="card-header">
            Users
        </div>
        <div class="card-body table-responsive">

            <div class="row pb-3">
                <div class="col text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                        <i data-feather="plus"></i>
                        <span class="ml-1">Add Participant</span>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            @if(route_exists('portfolio.preview'))
                                <th>Portfolio</th>
                            @endif
                            <th>Is Active</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php /** @var \App\Modules\Users\Models\User[] $users */ @endphp
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <img
                                            class="avatar avatar-sm"
                                            src="{{$user->avatar_url ?: '/assets/img/avataaars.svg'}}"
                                            alt="User Avatar">
                                    {{$user->name()}}
                                </td>
                                @if(route_exists('portfolio.preview'))
                                    <td>
                                        @if(!empty($user->getPortfolioUrl()))
                                            <a target="_blank"
                                               href="{{$user->getPortfolioUrl()}}">
                                                {{$user->getPortfolioUrl()}}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                @endif
                                <td>{{!!$user->is_active ? "Yes": "No"}}</td>
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
                </div>
            </div>

            <div class="row">
                <div class="col">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection

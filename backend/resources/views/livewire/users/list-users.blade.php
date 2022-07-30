<div class="card mb-4">
    <div class="card-header">
        Users
    </div>
    <div class="card-body table-responsive">

        <div class="row">
            <div class="col">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Site Status</th>
                        <th>Last Online (MC Server)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php /** @var \App\Modules\Users\Models\User[] $users */ @endphp
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img
                                        class="avatar avatar-sm"
                                        src="{{$user->avatar_url ?: '/assets/img/avataaars.svg'}}" alt="User Avatar">
                                {{$user->name()}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>{{!!$user->is_active ? "Active": "Inactive"}}</td>
                            <td>
                                {{now()}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</div>

@extends('layouts.admin')

@section('page-header', 'Security')

@section('content')

    @include('admin.shared.account')

    <div class="row">
        <div class="col-md-12">
            @include('admin.shared.errors')
        </div>

        <div class="col-md-8">

            <div class="card mb-4">
                <div class="card-header">
                    Password
                </div>
                <div class="card-body p-5">

                    <form action="{{route('users.change_password')}}" method="post">
                        @csrf


                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input class="form-control" type="password" name="old_password">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>

                        <input type="submit" value="Save" class="btn btn-success float-right">
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

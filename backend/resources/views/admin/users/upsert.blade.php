@extends('layouts.admin')

@section('content')

    <div class="card mb-4">

        <div class="card-header">
            Create User
        </div>

        <div class="card-body">
            @include('admin.shared.errors')

            <form action="{{ $action }}" method="post">
                @csrf

                @if(isset($user->id))
                    <input type="hidden" name="id" value="{{$user->id}}">
                @endif
                <div class="row">
                    <div class="form-group col-6">
                        <label for="first-name">First Name</label>
                        <input class="form-control" id="first-name" name="first_name" type="text"
                               value="{{old('first_name', $user->first_name ?: '')}}">
                    </div>

                    <div class="form-group col-6">
                        <label for="last-name">Last Name</label>
                        <input class="form-control" id="last-name" name="last_name" type="text"
                               value="{{old('last_name', $user->last_name ?: '')}}">
                    </div>

                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input
                            {{$editMode ? 'readonly' : ''}}
                            class="form-control"
                            id="email"
                            name="email" type="email"
                            value="{{old('email', $user->email ?: '')}}"
                        >
                    </div>




                    <div class="form-group col-6">
                        <label for="is-active">Is Active</label>
                        <select class="form-control" id="is-active" name="is_active">
                            <option value="0" {{old('is_active', $user->is_active ?: 0)  == 0 ? 'selected' : ''}}>
                                No
                            </option>
                            <option value="1" {{old('is_active', $user->is_active ?: 0) == 1 ? 'selected' : ''}}>
                                Yes
                            </option>
                        </select>
                    </div>

                    <div class="form-group col-6">
                        @if(!isset($user->id))
                            <label for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" value="">
                        @endif
                    </div>

                    <div class="col-6"></div>

                    <div class="form-group col-6">
                        <label for="role">
                            Role <br><small>admin, contributor, business_owner, customer</small>
                        </label>
                        <input class="form-control" id="role" name="role" type="text"
                               value="{{old('role', $user->role ?: '')}}">
                    </div>

                    <div class="col-12 text-right">
                        <input type="submit" value="Save" class="btn btn-success">
                    </div>

                </div>

            </form>
        </div>


    </div>

@endsection

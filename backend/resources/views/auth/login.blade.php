@extends('layouts.auth')

@section('content')

    <div class="bg-secondary">

        <div id="layoutAuthentication mt-5" style="padding: 120px 0;">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="{{ !empty($site->logo) ? 'col-lg-8' : 'col-lg-5'  }}">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-body">

                                        <div class="row d-flex justify-content-center align-items-center">

                                            @if(isset($site->logo) && !empty($site->logo))
                                                <div class="col">
                                                    <img class="img-fluid" src="{{$site->logo}}"
                                                         alt="Site Logo">
                                                </div>
                                            @endif

                                            <div class="col">

                                                <div class="justify-content-center">
                                                    <h3 class="font-weight-light my-4 text-center">
                                                        {{ $site->company_name }}
                                                    </h3>
                                                </div>

                                                <form method="POST" action="{{ route('login') }}">

                                                    @csrf
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="email">Email</label>
                                                        <input id="email" type="email"
                                                               class="form-control py-4 @error('email') is-invalid @enderror"
                                                               name="email" value="{{ old('email') }}" required
                                                               autocomplete="email" autofocus
                                                               placeholder="Enter email address">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>


                                                    <div class="form-group">

                                                        <label class="small mb-1" for="password">Password</label>
                                                        <input id="password" type="password"
                                                               placeholder="Enter password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               name="password" required
                                                               autocomplete="current-password"/>

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">

                                                            <input class="custom-control-input" type="checkbox"
                                                                   name="remember"
                                                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="remember">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div>
                                                        @include('admin.shared.errors')
                                                    </div>

                                                    <div
                                                        class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                        @if (Route::has('password.request'))
                                                            <a class="btn btn-link"
                                                               href="{{ route('password.request') }}">
                                                                {{ __('Forgot Your Password?') }}
                                                            </a>
                                                        @endif
                                                        <button type="submit" class="btn btn-primary float-right">
                                                            {{ __('Login') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <div class="small">
                                            @if (Route::has('register'))
                                            <a href="{{ route('register') }}">Register</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </div>
@endsection

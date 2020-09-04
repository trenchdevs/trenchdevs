@extends('layouts.home')

@section('content')
    <div class="bg-primary">

        <div id="layoutAuthentication" style="padding: 120px 0;">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-8 col-lg-9">
                                <div class="card my-5">
                                    <div class="card-body p-5 text-center">
                                        <div class="h3 font-weight-light mb-3">Create an Account</div>
                                    </div>
                                    <hr class="my-0"/>
                                    <div class="card-body p-5">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <label for="first-name"
                                                               class="text-gray-600 small">{{ __('First Name') }}</label>

                                                        <input id="first-name" type="text"
                                                               class="form-control form-control-solid py-4 @error('first_name') is-invalid @enderror"
                                                               name="first_name" value="{{ old('first_name') }}"
                                                               required
                                                               autocomplete="first_name" autofocus>

                                                        @error('first_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="last-name"
                                                           class="text-gray-600 small">{{ __('Last Name') }}</label>

                                                    <input id="last-name" type="text"
                                                           class="form-control form-control-solid py-4 @error('last_name') is-invalid @enderror"
                                                           name="last_name" value="{{ old('last_name') }}" required
                                                           autocomplete="last_name" autofocus>

                                                    @error('last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="form-group">

                                                <label for="email"
                                                       class="text-gray-600 small">{{ __('E-Mail Address') }}</label>

                                                <input id="email" type="email"
                                                       class="form-control form-control-solid py-4 @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="text-gray-600 small"
                                                               for="password">{{ __('Password') }}</label>

                                                        <input id="password" type="password"
                                                               class="form-control form-control-solid py-4 @error('password') is-invalid @enderror"
                                                               name="password" required autocomplete="new-password">

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password-confirm"
                                                               class="text-gray-600 small">{{ __('Confirm Password') }}</label>
                                                        <input id="password-confirm" type="password"
                                                               class="form-control form-control-solid py-4"
                                                               name="password_confirmation" required
                                                               autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group d-flex align-items-center justify-content-between">
                                                <div class="custom-control custom-control-solid custom-checkbox">
                                                    <input class="custom-control-input small" id="tnc"
                                                           type="checkbox" name="tnc" value="yes" required/>
                                                    <label class="custom-control-label mr-3" for="tnc">
                                                        I accept the
                                                        <a target="_blank" href="{{route('documents.tnc')}}">terms &amp; conditions</a>.
                                                    </label>
                                                    @error('tnc')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">
                                                    Create Account
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="my-0"/>
                                    <div class="card-body px-5 py-4">
                                        <div class="small text-center">Have an account?
                                            <a href="{{ route('login') }}">Sign in!</a>
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

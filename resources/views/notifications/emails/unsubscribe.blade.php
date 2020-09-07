@extends('layouts.home')

@section('content')
    <div class="container">


        <div class="row justify-content-center" style="height: 60vh; margin-top: 20vh;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Unsubscribe') }}</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-info">
                                        {{ Session::get('message') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('notifications.emails.unsubscribe') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-6 text-right">
                                    <input type="submit" value="Unsubscribe" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

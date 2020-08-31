@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        <p>
                            {{ __('Before proceeding, please check your email for a verification link.') }} <br>
                            <em>
                                Kindly check your promotions or spam folder if email is not visible on your primary
                                mailbox.
                            </em> <br>
                            If you did not receive email, please send us an email at
                            <strong>support@trenchdevs.org</strong> and we will try to verify it for you.
                        </p>
                        {{--                    {{ __('If you did not receive the email') }},--}}
                        {{--                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">--}}
                        {{--                        @csrf--}}
                        {{--                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.--}}
                        {{--                    </form>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('emails.layout')

@section('email_header')
    @if(isset($name) && !empty($name))
        Dear {{$name}},
    @endif
@endsection

@section('email_body')
    {!! $email_body !!}
@endsection

@extends('emails.layout')

@section('email_header')
    Dear {{$name}},
@endsection

@section('email_body')
    {{ $email_message  }}
@endsection

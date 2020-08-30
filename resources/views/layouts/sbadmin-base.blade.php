<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'TrenchDevs')  }}</title>
    <link href="/admin/css/styles.css" rel="stylesheet"/>
    <link rel="icon" href="/favicon.png"/>

    @yield('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"
            crossorigin="anonymous">
    </script>

{{--    @include('layouts.partials.ga')--}}

</head>
<body class="nav-fixed">

<div id="app">
    <div id="vue-app">
        @yield('body')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js', env('APP_ENV') === 'production') }}"></script>
<script src="/admin/js/admin-scripts.js"></script>

@yield('scripts')

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>--}}
</body>
</html>

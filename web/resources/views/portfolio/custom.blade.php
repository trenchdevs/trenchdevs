<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME')  }}</title>
    <link href="/admin/css/styles.css" rel="stylesheet"/>
    <link rel="icon" href="/favicon.png"/>

    @include('layouts.partials.ga')

    <style>
        body {
            margin: 0;
        }

        iframe {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>
<iframe width="100%" height="100%" src="{{$site}}" frameborder="0"></iframe>
</body>
</html>


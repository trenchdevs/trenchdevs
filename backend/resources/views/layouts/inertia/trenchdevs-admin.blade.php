<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ site()->company_name ?? 'TD'  }}</title>
    <link href="/admin/css/styles.css" rel="stylesheet"/>
    <link rel="icon" href="/favicon.png"/>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite('resources/js/app.jsx')
    @inertiaHead

    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"
            crossorigin="anonymous">
    </script>

    <style>
        .card-header {
            background-color: #1f2d41;
            color: white !important;
        }

        /** Paginations */
        .pagination > li > a {
            background-color: white;
            color: #5A4181;
        }

        nav#sidenavAccordion {
            background: #00ac69 !important;
        }

        /*#navbarDropdownUserImage{*/
        /*    background-color: #1f2d41;*/
        /*    color: white !important;*/
        /*}*/

        /*.dropdown-menu .dropdown-header {*/
        /*    color: white !important;*/
        /*}*/


        li.page-item.active > .page-link {
            color: white;
            background-color: #1f2d41 !important;
            border-color: #1f2d41 !important;
        }

        .pagination > li > a:focus, .pagination > li > a:hover, .pagination > li > span:focus, .pagination > li > span:hover {
            color: white;
            background-color: #1f2d418f !important;
            border-color: transparent;
        }

        .topnav.navbar-light .navbar-brand {
            color: #eff3f9 !important;
        }

        #sidebarToggle {
            color: white !important;
        }

    </style>

    @include('layouts.partials.ga')
</head>
<body>

@inertia

<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="/admin/js/admin-scripts.js"></script>

@yield('scripts')

</body>
</html>

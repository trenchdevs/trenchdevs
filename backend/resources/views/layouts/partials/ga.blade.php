@if(env('APP_ENV') === 'production')
{{--    <!-- Global site tag (gtag.js) - Google Analytics -->--}}
{{--    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-176783752-1"></script>--}}
{{--    <script>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}

{{--        function gtag() {--}}
{{--            dataLayer.push(arguments);--}}
{{--        }--}}

{{--        gtag('js', new Date());--}}

{{--        gtag('config', 'UA-176783752-1');--}}
{{--    </script>--}}

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-2GG77DGKJY"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-2GG77DGKJY');
    </script>
@endif

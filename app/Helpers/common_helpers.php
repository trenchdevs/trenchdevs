<?php


if (!function_exists('get_base_url')) {
    function get_base_url()
    {
        return env('BASE_URL', 'trenchdevs.test');
    }
}

if (!function_exists('get_portfolio_url')) {
    function get_portfolio_url(string $username)
    {
        return add_scheme_to_url(sprintf('%s.%s', $username, get_base_url()));
    }
}


if (!function_exists('add_scheme_to_url')) {
    function add_scheme_to_url(string $url)
    {
        $scheme = "http://";

        if (env('APP_ENV') === 'production') {
            $scheme = 'https://';
        }

        return "{$scheme}{$url}";
    }
}

if (!function_exists('print_json')) {
    function print_json($var, bool $die = false)
    {
        echo json_encode($var, JSON_PRETTY_PRINT);

        if ($die) {
            die;
        }
    }
}

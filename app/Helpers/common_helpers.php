<?php


if (!function_exists('get_base_url')) {
    /**
     * @return mixed|string
     */
    function get_base_url()
    {
        return env('BASE_URL', 'trenchdevs.test');
    }
}

if (!function_exists('get_portfolio_url')) {
    /**
     * @param string $username
     * @return string
     */
    function get_portfolio_url(string $username)
    {
        return add_scheme_to_url(sprintf('%s.%s', $username, get_base_url()));
    }
}


if (!function_exists('add_scheme_to_url')) {
    /**
     * @param string $url
     * @return string
     */
    function add_scheme_to_url(string $url)
    {
        $scheme = "http://";

        if (env('APP_ENV') === 'production') {
            $scheme = 'https://';
        }

        return "{$scheme}{$url}";
    }
}

if (!function_exists('get_site_url')) {
    /**
     * @param string $url
     * @return string
     */
    function get_site_url()
    {
        return add_scheme_to_url(get_base_url());
    }
}

if (!function_exists('print_json')) {
    /**
     * @param $var
     * @param bool $die
     */
    function print_json($var, bool $die = false)
    {
        echo json_encode($var, JSON_PRETTY_PRINT);

        if ($die) {
            die;
        }
    }
}

if (!function_exists('mysql_now')) {
    /**
     * @return string
     */
    function mysql_now(): string
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('humanize')) {
    /**
     * @param string $str
     * @return string
     */
    function humanize(string $str): string
    {
        return str_replace('_', ' ', $str);
    }
}


if (!function_exists('str_to_date_format')) {
    /**
     * @param string $str
     * @param string $format
     * @return string
     */
    function str_to_date_format(string $str, string $format): string
    {
        return date($format, strtotime($str));
    }
}

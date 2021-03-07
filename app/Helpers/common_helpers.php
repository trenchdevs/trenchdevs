<?php


use Carbon\Carbon;

if (!function_exists('get_base_url')) {
    /**
     * @return mixed|string
     */
    function get_base_url()
    {
        $fullUrl = url('/');
        $fullDomain = explode('//', $fullUrl)[1]; // c.trenchdevs.org

        if (!empty($fullDomain)) {
            $domainParts = explode('.', $fullDomain);
            $tld = array_pop($domainParts);
            $domain = array_pop($domainParts);
            return "{$domain}.{$tld}";
        }

        return env('BASE_URL', 'trenchdevs.test');
    }
}

if (!function_exists('get_site_url')) {
    /**
     * @return mixed|string
     */
    function get_site_url()
    {
        return add_scheme_to_url(get_base_url());
    }
}


if (!function_exists('get_portfolio_url')) {
    /**
     * @param string $username
     * @return string
     */
    function get_portfolio_url(string $username)
    {
        return add_scheme_to_url(sprintf('%s/%s', get_base_url(), $username));
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


if (!function_exists('is_valid_url')) {
    /**
     * @param $url
     * @return string
     */
    function is_valid_url($url): string
    {

        if (!is_string($url)) {
            return false;
        }

        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}

if (!function_exists('s3_generate_file_path')) {
    /**
     * @param string $filePath eg. 'users/avatar'
     * @return string
     * @throws ErrorException
     */
    function s3_generate_file_path(string $filePath, string $fileName): string
    {

        $appEnv = env('APP_ENV');

        if (!$appEnv) {
            throw new ErrorException("APP_ENV not set");
        }

        return "{$appEnv}/{$filePath}/{$fileName}";
    }
}

/**
 * Dates
 */

if (!function_exists('is_valid_date')) {
    /**
     * @param string $dateString
     * @param string $dateFormat
     * @return string
     */
    function is_valid_date(string $dateString, string $dateFormat = "Y-m-d"): string
    {
        return Carbon::createFromFormat($dateFormat, $dateString);
    }
}

<?php


use App\Models\Site;
use Carbon\Carbon;

if (!function_exists('get_base_url')) {
    /**
     * @param bool $removePort
     * @return mixed|string
     */
    function get_base_url(bool $removePort = false)
    {
        $fullUrl = url('/');
        $fullDomain = explode('//', $fullUrl)[1]; // c.trenchdevs.org

        if (!empty($fullDomain)) {
            $domainParts = explode('.', $fullDomain);
            $tld = array_pop($domainParts);
            $domain = array_pop($domainParts);

            if ($removePort) {
                $tld = explode(":",$tld)[0] ?? '';
            }

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
     * @param string $fileName
     *
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


/**
 *
 */
if (!function_exists('request_meta')) {
    /**
     * @param bool $encode
     * @return array|string
     */
    function request_meta($encode = false)
    {
        $request = request();

        $user = $request->user('web');
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        $method = $request->method();
        $requestData = $request->all();
        $fullUrl = $request->fullUrl();

        $meta = [
            'user' => $user,
            'ip' => $ip,
            'user_agent' => $userAgent,
            'method' => $method,
            'request_data' => $requestData,
            'full_url' => $fullUrl,
        ];

        if ($encode) {
            return json_encode($meta);
        } else {
            // return array
            return $meta;
        }
    }
}

if (!function_exists('get_domain')) {

    function get_domain(): string
    {
        return request()->getHost();
    }
}


if (!function_exists('site')) {

    function site(): Site {
        $site = Site::getInstance();

        if (!$site) {
            $site = new Site;
        }

        return $site;
    }
}

/**
 * @param $string
 *
 * @return bool
 */
function td_is_json($string): bool {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

function json_decode_or_default($var, bool $default = null, $assoc = true) {

    if (td_is_json($var)) {
        return json_decode($var, $assoc);
    }

    return $default;
}

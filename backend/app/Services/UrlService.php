<?php

namespace App\Services;

class UrlService
{

    /**
     * Remove https:// or http:// part
     * @param string $url
     * @return string
     */
    public function removeScheme(string $url): string
    {
        $url = str_replace('https://', '', $url);
        $url = str_replace('http://', '', $url);
        return $url;
    }
}

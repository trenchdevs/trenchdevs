<?php

namespace App\Http\Controllers;

class WebApiController extends AuthWebController
{

    public function init()
    {

        $site = $this->user->site;
        $siteDetails = $site->attributesToArray();
        $siteDetails['full_domain'] = app()->environment('local') ? "http://{$site->domain}" : "https://{$site->domain}";

        $userDetails = $this->user->attributesToArray();

        return [
            'site' => $siteDetails,
            'user' => $userDetails,
            'server' => [
                'time' => date('Y-m-d H:i:s'),
            ]
        ];
    }

}

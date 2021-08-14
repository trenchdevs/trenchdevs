<?php

namespace App\Http\Controllers;


use App\Domains\Sites\Models\Site;

class WebApiController extends AuthWebController
{

    public function init()
    {

        $site = $this->user->site;
        $now = now();

        return [
            'site' => $site,
            'user' => $this->user->attributesToArray(),
            'server' => [
                'time' => $now->format('Y-m-d H:i:s'),
            ]
        ];
    }

    public function initSite()
    {
        return Site::getInstance()->attributesToArray();
    }

    public function initUser()
    {
        return $this->user->attributesToArray();
    }

}

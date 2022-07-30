<?php

namespace App\Modules\Sso\Http\Controllers;

use App\Modules\Sites\Models\Sites\SiteConfig;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TdMetadataController extends Controller
{

    /**
     * @return Application|ResponseFactory|Response [type] [description]
     * @throws FileNotFoundException
     */
    public function index(): Response|Application|ResponseFactory
    {
        // Check for debugbar and disable for this view
        if (class_exists('\Barryvdh\Debugbar\Facade')) {
            \Barryvdh\Debugbar\Facade::disable();
        }

        $cert = config('samlidp.certificate');
        $cert = preg_replace('/^\W+\w+\s+\w+\W+\s(.*)\s+\W+.*$/s', '$1', trim($cert));
        $cert = str_replace(PHP_EOL, "", $cert);

        if (empty($site = site()) || $site->getConfigValueByKey(SiteConfig::KEY_NAME_SITE_SAMLIDP_ENABLED) != 1) {
            abort(403);
        }

        return response(view('samlidp::metadata', compact('cert')), 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}

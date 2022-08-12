<?php

namespace App\Modules\Sso\Console\Commands;

use App\Modules\Sites\Models\Site;
use App\Modules\Sites\Models\SiteConfig;
use App\Modules\Sites\Models\SiteJson;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SamlIdpCreateServiceProvider extends Command
{

    protected $signature = 'td:samlidp:sp:create';

    public function handle()
    {
        $siteId    = $this->ask('What is the site_id?');
        $acsUrl    = $this->ask('What is the service provider ACS URL?');
        $logoutUrl = $this->ask('What is the service provider logout URL?');
        $loginUrl  = $this->ask('What is the service provider login URL?');

        /** @var Site $site */
        $site          = Site::query()->findOrFail($siteId);
        $encodedAcsUrl = base64_encode($acsUrl);

        $this->line('SamlIdp config:');
        $this->line('');
        $this->line("'{$encodedAcsUrl}' => [");
        $this->line("    'destination' => '{$acsUrl}',");
        $this->line("    'logout' => '{$logoutUrl}',");
        $this->line("]");

        $samlidp = [
            // idp
            'certificate' => 'TODO: To be manually filled up',
            'key'         => 'TODO: To be manually filled up',

            'sp' => [
                'login_url'    => $loginUrl,
                $encodedAcsUrl => [
                    'destination'  => $acsUrl,
                    'logout'       => $logoutUrl,
                    'query_params' => false,
                    'certificate'  => 'TODO: To be manually filled up',
                ]
            ],
        ];

        $samlIdpJson = json_encode($samlidp, JSON_PRETTY_PRINT);

        DB::table('site_jsons')->updateOrInsert(
            ['key' => SiteJson::KEY_SAML_IDP, 'site_id' => $siteId],
            ['value' => $samlIdpJson],
        );

        SiteConfig::query()->updateOrCreate(
            ['key_name' => SiteConfig::KEY_NAME_SITE_SAMLIDP_ENABLED, 'site_id' => $siteId],
            ['key_value' => 1],
        );

        $this->line('Success');
        $this->line('Next Step: 1.) x509 Certificate of Service Provider should be installed manually via samlidp::sp.certificate');
        $this->line('Next Step: 2.) Ensure server has keys installed if not php artisan samlidp:cert');
    }
}

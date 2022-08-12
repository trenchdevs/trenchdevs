<?php

namespace Tests\Feature;

use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use Tests\SiteTransactionTestCase;
use Tests\TestCase;

class ExampleTest extends SiteTransactionTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
//        $url = $this->get();

//        $curl = curl_init($this->site->http('/'));
////        curl_setopt($curl, CURLOPT_URL, $this->site->http('/'));
////        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
////
//////for debug only!
////        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
////        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
////        $result = curl_exec($curl);
////
////        dd($result);
///
        Site::setInstance($this->site);
        dd(Site::getInstance());
        die;
//        dd(Site::getInstance());
        $response = $this->get($this->site->http('/'));
        $response->dd();

        $response->assertStatus(200);
    }

    public function siteIdentifier(): SiteIdentifier
    {
        return SiteIdentifier::TRENCHDEVS;
    }
}

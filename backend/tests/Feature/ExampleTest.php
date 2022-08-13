<?php

namespace Tests\Feature;

use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use Tests\SiteTransactionTestCase;
use Tests\TestCase;

class ExampleTest extends SiteTransactionTestCase
{

    /**
     * @return SiteIdentifier
     */
    public function siteIdentifier(): SiteIdentifier
    {
        return SiteIdentifier::TRENCHDEVS;
    }

    /**
     * @test
     * @return void
     */
    public function basicTest(): void
    {
        $this->assertEquals(SiteIdentifier::TRENCHDEVS->value, $this->site->identifier);
    }

}

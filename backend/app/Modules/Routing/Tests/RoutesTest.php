<?php

namespace App\Modules\Routing\Tests;

use App\Modules\Sites\Models\Site;
use App\Modules\Sites\Models\Sites\SiteFactory;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function routeListTest(): void
    {
        app()->singleton(Site::class, fn() => Site::query()->find(1));
        $this->artisan("route:list")->assertExitCode(0);
    }

}

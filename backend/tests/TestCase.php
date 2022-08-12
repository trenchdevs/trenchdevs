<?php

namespace Tests;

use App\Modules\Sites\Models\Site;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Utilities\DataCreator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param Site $site
     * @return DataCreator
     */
    protected function newDummyDataCreatorInstance(Site $site): DataCreator
    {
        return new DataCreator($site);
    }
}

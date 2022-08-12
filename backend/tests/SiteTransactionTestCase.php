<?php

namespace Tests;

use App\Modules\Sites\Enums\SiteIdentifier;
use App\Modules\Sites\Models\Site;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Utilities\DataCreator;

abstract class SiteTransactionTestCase extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var DataCreator
     */
    protected DataCreator $creator;
    protected Site $site;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->site = Site::fromIdentifier($this->siteIdentifier());
        $this->creator = new DataCreator($this->site);
    }

    public abstract function siteIdentifier(): SiteIdentifier;

}

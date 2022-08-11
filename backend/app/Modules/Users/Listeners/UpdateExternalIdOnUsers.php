<?php

namespace App\Modules\Users\Listeners;

use App\Modules\Users\Events\UserPortfolioDetailsUpdated;

class UpdateExternalIdOnUsers {

    public function __construct()
    {
    }

    public function handle(UserPortfolioDetailsUpdated $event): void
    {

        $event->userPortfolioDetail->user()->update([
            'external_id' => $event->userPortfolioDetail->value['external_id'] ?? '',
        ]);
    }
}

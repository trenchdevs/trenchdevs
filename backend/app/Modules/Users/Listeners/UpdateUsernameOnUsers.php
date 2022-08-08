<?php

namespace App\Modules\Users\Listeners;

use App\Modules\Users\Events\UserPortfolioDetailsUpdated;

class UpdateUsernameOnUsers {

    public function __construct()
    {
    }

    public function handle(UserPortfolioDetailsUpdated $event): void
    {

        $event->userPortfolioDetail->user()->update([
            'username' => $event->userPortfolioDetail->value['username'] ?? '',
        ]);
    }
}

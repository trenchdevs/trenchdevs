<?php

namespace App\Modules\Users\Events;

use App\Modules\Users\Models\UserJsonAttribute;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPortfolioDetailsUpdated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public UserJsonAttribute $userPortfolioDetail;

    public function __construct(UserJsonAttribute $userPortfolioDetail)
    {
        $this->userPortfolioDetail = $userPortfolioDetail;
    }

}

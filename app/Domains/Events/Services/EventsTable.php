<?php

namespace App\Domains\Events\Services;

use App\Domains\Events\Models\Event;
use App\Services\MaterialTableService;

class EventsTable extends MaterialTableService {

    public function query()
    {
        return Event::query();
    }

    public function filter()
    {

    }
}

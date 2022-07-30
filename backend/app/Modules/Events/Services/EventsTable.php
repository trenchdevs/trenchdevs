<?php

namespace App\Modules\Events\Services;

use App\Modules\Events\Models\Event;
use App\Services\MaterialTableService;

class EventsTable extends MaterialTableService {

    public function query()
    {
        return Event::query()->orderBy('id', 'desc');
    }

    public function filter()
    {

    }
}

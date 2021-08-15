<?php

namespace App\Domains\Events\Http\Controllers;

use App\Domains\Events\Services\EventsTable;
use App\Http\Controllers\WebApiController;

class EventsController extends WebApiController
{

    /**
     * Site agnostic endpoint for getting paginated users
     */
    public function getEvents()
    {
        return ( new EventsTable(site()))->response();
    }



}

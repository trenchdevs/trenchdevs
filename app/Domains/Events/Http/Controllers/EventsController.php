<?php

namespace App\Domains\Events\Http\Controllers;

use App\Domains\Events\Models\Event;
use App\Domains\Events\Services\EventsTable;
use App\Http\Controllers\WebApiController;

class EventsController extends WebApiController
{

    /**
     * Site agnostic endpoint for getting paginated events
     */
    public function getEvents()
    {
        return (new EventsTable(site()))->response();
    }

    public function details(int $eventId)
    {
        return $this->webApiResponse('Successfully fetched Event', function () use ($eventId) {
            return Event::query()->findOrFail($eventId);
        });
        // todo: chris
    }

    public function upsert()
    {
        // todo: chris
    }


    public function delete()
    {
        // todo: chris
    }

}

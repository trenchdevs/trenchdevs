<?php

namespace App\Domains\Events\Http\Controllers;

use App\Domains\Events\Models\Event;
use App\Domains\Events\Services\EventsTable;
use App\Http\Controllers\WebApiController;
use Illuminate\Http\Request;
use InvalidArgumentException;

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
        return $this->webApiResponse(function () use ($eventId) {

            $event = Event::query()->find($eventId);

            if (empty($event)) {
                throw new InvalidArgumentException("Unable to find event.");
            }

            return $event;
        }, 'Successfully fetched Event');
    }

    public function upsert(Request $request)
    {
        return $this->webApiResponse(function () use ($request) {
            return Event::query()->updateOrCreate(
                [
                    'site_id' => site()->id,
                    'id' => $request->input('id')
                ],
                $request->all()
            );
        }, !empty($request->input('id')) ? "Successfully updated event" : "Successfully created event");
    }

}

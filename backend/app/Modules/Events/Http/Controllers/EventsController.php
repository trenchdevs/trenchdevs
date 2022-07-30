<?php

namespace App\Modules\Events\Http\Controllers;

use App\Modules\Events\Models\Event;
use App\Modules\Events\Services\EventsTable;
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

            $this->validate($request, [
                'id' => 'nullable|numeric',
                'name' => 'required|max:64',
                'location' => 'nullable|max:64',
                'description' => 'nullable|max:128',
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
            ]);

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Notes\Note;

class ApiNotes extends ApiController
{

    /**
     * Get all notes
     */
    public function index()
    {
        return $this->responseHandler(function (){

            $notes = Note::query()->simplePaginate(10);

            // todo: chris refactor
            foreach( $notes as &$note) {
                $note['contents'] = json_decode($note['contents'] ?? [], true);
            }

            return $notes;
        });
    }

}

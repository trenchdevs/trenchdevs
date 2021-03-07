<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Notes\Note;
use App\Repositories\Notes\NotesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiNotes extends ApiController
{

    /** @var NotesRepository */
    protected $notesRepo;

    public function __construct(NotesRepository $notesRepo)
    {
        $this->notesRepo = $notesRepo;
    }

    /**
     * POST
     * Get all notes
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->responseHandler(function () use ($request) {
            return $this->notesRepo->all($request->all());
        });
    }

}

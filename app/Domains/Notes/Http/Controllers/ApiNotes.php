<?php

namespace App\Domains\Notes\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\Domains\Notes\Repositories\NotesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiNotes extends ApiController
{

    /** @var NotesRepository */
    protected $notesRepo;

    public function __construct(NotesRepository $notesRepo)
    {
        parent::__construct();
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
            return $this->notesRepo->all($this->getLoggedInUser(), $request->all());
        });
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upsert(Request $request)
    {
        return $this->responseHandler(function () use ($request) {
            return !!$this->notesRepo->upsert($this->getLoggedInUser(), $request->all());
        });
    }

}

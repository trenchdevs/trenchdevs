<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Models\Projects\Project;
use App\Repositories\UserProjectsRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserProjectsController extends AuthWebController
{


    private $projectsRepository;

    /**
     * UserProjectsController constructor.
     * @param UserProjectsRepository $projectsRepository
     */
    public function __construct(UserProjectsRepository $projectsRepository)
    {
        $this->projectsRepository = $projectsRepository;
    }

    public function list()
    {
        $projects = Project::orderBy('id', 'desc')
            ->paginate();

        return view('projects.list', [
            'projects' => $projects,
        ]);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'projects' => 'required|array|present',
            'projects.*.is_personal' => 'required|boolean',
            'projects.*.title' => 'required|string|max:128',
            'projects.*.url' => 'nullable|url',
            'projects.*.repository_url' => 'nullable|url',
            'projects.*.users' => 'nullable|array',
            'projects.*.users.*.id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->validationFailureResponse($validator);
        }

        /** @var User $user */
        $user = $request->user();

        $projects = $this->projectsRepository->saveRawProjects($user, $request->get('projects'));

        if (empty($projects)) {
            $this->jsonResponse(self::STATUS_ERROR, 'There was a problem while saving projects');
        }

        return $this->jsonResponse('success', 'Successfully updated entries', ['projects' => $user->projects]);
    }

    public function getProjects(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $projects = $user->projects;

//        dd('test');

        if (!empty($projects)) {
            return $this->jsonResponse(self::STATUS_SUCCESS, "Success", ['projects' => $projects], []);
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, "No projects found");
        }

    }

    public function delete(Request $request)
    {

        /** @var User $user */
        $user = $request->user();

        /** @var Project $userProject */
        $userProject = Project::findOrFail($request->id);

        if ($user->id !== $userProject->user_id) {
            return $this->jsonResponse(self::STATUS_ERROR, "Forbidden");
        }

        $success = $this->projectsRepository->deleteProject($userProject);

        if ($success === true) {
            return $this->jsonResponse(self::STATUS_SUCCESS, "Success");
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, "There was a problem deleting the project");
        }

    }
}

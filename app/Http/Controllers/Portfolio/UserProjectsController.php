<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Users\UserProject;
use App\Repositories\UserProjectsRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserProjectsController extends Controller
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

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'projects' => 'required|array|present',
            'projects.*.is_personal' => 'required|string|max:128',
            'projects.*.title' => 'required|string|max:128',
            'projects.*.url' => 'nullable|url',
            'projects.*.repository_url' => 'nullable|url',
            'projects.*.users' => 'nullable|exists|array',
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

        /** @var UserProject $userProject */
        $userProject = UserProject::findOrFail($request->id);

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

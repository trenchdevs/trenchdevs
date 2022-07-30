<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Projects\Models\Project;
use App\Modules\Users\Models\ProjectUser;
use App\Modules\Users\Models\UserDegree;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class UserProjectsRepository
{
    /**
     * @param User $forUser
     * @param array $rawProjects
     * @return UserDegree[]
     * @throws
     */
    public function saveRawProjects(User $forUser, array $rawProjects): array
    {

        $userProjects = [];

        try {

            DB::beginTransaction();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            if (empty($rawProjects)) {
                throw new InvalidArgumentException("Empty projects given");
            }

            foreach($forUser->projects as $oldProject) {
                $this->deleteProject($oldProject);
            }

            foreach ($rawProjects as $rawProject) {
                $userProject = new Project();
                $rawProject['user_id'] = $forUser->id;
                $userProject->fill($rawProject);
                $userProject->saveOrFail();
                $userProjects[] = $userProject;

                if(!$userProject->is_personal){
                    foreach ($userProjects['users'] as $user) {
                        $projectUser = new ProjectUser();
                        $projectUser->user_id = $user->id;
                        $projectUser->project_id = $userProject->id;
                        $projectUser->saveOrFail();
                    }
                }
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $userProjects = [];
            throw $exception;
        }

        return $userProjects;

    }

    public function deleteProject(Project $project){

        try {
            DB::beginTransaction();

            if(!$project->is_personal){
                foreach ($project->projectUsers as $projectUser) {
                    $projectUser->delete();
                }
            }

            $project->delete();

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        return true;
    }
}

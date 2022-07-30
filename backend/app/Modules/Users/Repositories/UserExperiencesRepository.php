<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Models\UserDegree;
use App\Modules\Users\Models\UserExperience;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class UserExperiencesRepository
{
    /**
     * @param User $forUser
     * @param array $rawExperiences
     * @return UserDegree[]
     * @throws
     */
    public function saveRawExperiences(User $forUser, array $rawExperiences): array
    {

        $userExperiences = [];

        try {

            DB::beginTransaction();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            if (empty($rawExperiences)) {
                throw new InvalidArgumentException("Empty experiences given");
            }

            foreach($forUser->experiences as $oldExperience) {
                $oldExperience->delete();
            }

            foreach ($rawExperiences as $rawExperience) {
                $userExperience = new UserExperience();
                $rawExperience['user_id'] = $forUser->id;
                $userExperience->fill($rawExperience);
                $userExperience->saveOrFail();
                $userExperiences[] = $userExperience;
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $userExperiences = [];
            throw $exception;
        }

        return $userExperiences;

    }
}

<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Sites\Models\Account;
use App\Modules\Users\Models\UserDegree;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserLogin;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class UserDegreesRepository
{
    /**
     * @param User $forUser
     * @param array $rawDegrees
     * @return UserDegree[]
     * @throws
     */
    public function saveRawDegrees(User $forUser, array $rawDegrees): array
    {

        $userDegrees = [];

        try {

            DB::beginTransaction();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            if (empty($rawDegrees)) {
                throw new InvalidArgumentException("Empty degrees given");
            }

            foreach($forUser->degrees as $oldDegree) {
                $oldDegree->delete();
            }

            foreach ($rawDegrees as $rawDegree) {
                $userDegree = new UserDegree();
                $rawDegree['user_id'] = $forUser->id;
                $userDegree->fill($rawDegree);
                $userDegree->saveOrFail();
                $userDegrees[] = $userDegree;
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $userDegrees = [];
            throw $exception;
        }

        return $userDegrees;

    }
}

<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Sites\Models\Account;
use App\Domains\Users\Models\UserDegree;
use App\Domains\Users\Models\User;
use App\Domains\Users\Models\UserLogin;
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

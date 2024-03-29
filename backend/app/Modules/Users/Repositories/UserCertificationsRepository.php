<?php

namespace App\Modules\Users\Repositories;


use App\Modules\Users\Models\UserCertification;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserLogin;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class UserCertificationsRepository
{
    /**
     * @param User $forUser
     * @param array $rawCertifications
     * @return UserCertification[]
     * @throws
     */
    public function saveRawCertifications(User $forUser, array $rawCertifications): array
    {

        $userCertifications = [];

        try {

            DB::beginTransaction();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            if (empty($rawCertifications)) {
                throw new InvalidArgumentException("Empty certifications given");
            }

            foreach($forUser->certifications as $oldCertification) {
                $oldCertification->delete();
            }

            foreach ($rawCertifications as $rawCertification) {
                $userCertification = new UserCertification();
                $rawCertification['user_id'] = $forUser->id;
                $userCertification->fill($rawCertification);
                $userCertification->saveOrFail();
                $userCertifications[] = $userCertification;
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $userCertifications = [];
            throw $exception;
        }

        return $userCertifications;

    }
}

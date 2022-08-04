<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Models\UserDegree;
use App\Modules\Users\Models\UserExperience;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserJsonAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;

class UserExperiencesRepository
{
    /**
     * @param User $forUser
     * @param array $request
     * @return UserDegree[]
     * @throws Throwable
     * @throws ValidationException
     */
    public function saveRawExperiences(User $forUser, array $request): array
    {

        $userExperiences = [];

        try {

            DB::beginTransaction();

            $validator = Validator::make($request, [
                'experiences' => 'required|array|present',
                'experiences.*.title' => 'required|string|max:128',
                'experiences.*.company' => 'required|string|max:128',
                'experiences.*.description' => 'required|string|max:6144',
                'experiences.*.start_date' => 'required|date',
                'experiences.*.end_date' => 'nullable|date'
            ], [], [
                'experiences' => 'Experiences',
                'experiences.*.title' => 'Title',
                'experiences.*.company' => 'Company',
                'experiences.*.description' => 'Description',
                'experiences.*.start_date' => 'Start Date',
                'experiences.*.end_date' => 'End Date'
            ]);

            $validator->validate();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            // todo: chris after validation - store directly as JSON
            $rawExperiences = $request['experiences'] ?? [];


            // system::portfolio::experiences
            UserJsonAttribute::query()->updateOrCreate(
                ['user_id' => $forUser->id, 'key' => 'system::portfolio::experiences'],
                ['value' => $rawExperiences]
            );

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $userExperiences;

    }
}

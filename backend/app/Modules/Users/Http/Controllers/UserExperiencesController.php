<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Repositories\UserExperiencesRepository;
use App\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserExperiencesController extends Controller
{


    private $experiencesRepository;

    /**
     * UserExperiencesController constructor.
     * @param UserExperiencesRepository $experiencesRepository
     */
    public function __construct(UserExperiencesRepository $experiencesRepository)
    {
        $this->experiencesRepository = $experiencesRepository;
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'experiences' => 'required|array|present',
            'experiences.*.title' => 'required|string|max:128',
            'experiences.*.company' => 'required|string|max:128',
            'experiences.*.description' => 'required|string|max:6144', // consult Chris later on (database column type is TEXT)
            'experiences.*.start_date' => 'required|date',
            'experiences.*.end_date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return $this->validationFailureResponse($validator);
        }

        /** @var User $user */
        $user = $request->user();

        $experiences = $this->experiencesRepository->saveRawExperiences($user, $request->get('experiences'));

        if (empty($experiences)) {
            $this->jsonResponse(self::STATUS_ERROR, 'There was a problem while saving experiences');
        }

        return $this->jsonResponse('success', 'Successfully updated entries', ['experiences' => $user->experiences]);
    }

    public function getExperiences(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $experiences = $user->experiences;

        if (!empty($experiences)) {
            return $this->jsonResponse(self::STATUS_SUCCESS, "Success", ['experiences' => $experiences], []);
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, "No experiences found");
        }

    }
}

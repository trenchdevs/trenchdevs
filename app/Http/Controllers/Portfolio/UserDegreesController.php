<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Repositories\UserDegreesRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserDegreesController extends Controller
{


    private $degreesRepository;

    /**
     * UserDegreesController constructor.
     * @param UserDegreesRepository $degreesRepository
     */
    public function __construct(UserDegreesRepository $degreesRepository)
    {
        $this->degreesRepository = $degreesRepository;
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'degrees' => 'required|array|present',
            'degrees.*.educational_institution' => 'required|string',
            'degrees.*.degree' => 'required|string',
            'degrees.*.description' => 'required|string',
            'degrees.*.start_date' => 'required|date',
            'degrees.*.end_date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return $this->validationFailureResponse($validator);
        }

        /** @var User $user */
        $user = $request->user();

        $degrees = $this->degreesRepository->saveRawDegrees($user, $request->get('degrees'));

        if (empty($degrees)) {
            $this->jsonResponse(self::STATUS_ERROR, 'There was a problem while saving degrees');
        }

        return $this->jsonResponse('success', 'Successfully, updated entries', ['degrees' => $user->degrees]);
    }

    public function getDegrees(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $degrees = $user->degrees;

        if (!empty($degrees)) {
            return $this->jsonResponse(self::STATUS_SUCCESS, "Success", ['degrees' => $degrees], []);
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, "No degrees found");
        }

    }
}

<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Repositories\UserCertificationsRepository;
use App\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserCertificationsController extends Controller
{

    private $certificationsRepository;

    /**
     * UserCertificationsController constructor.
     * @param UserCertificationsRepository $certificationsRepository
     */
    public function __construct(UserCertificationsRepository $certificationsRepository)
    {
        $this->certificationsRepository = $certificationsRepository;
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'certifications' => 'required|array|present',
            'certifications.*.title' => 'required|string',
            'certifications.*.issuer' => 'required|string',
            'certifications.*.issuance_date' => 'required|date',
            'certifications.*.certification_url' => 'nullable|string|url',
            'certifications.*.expiration_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->validationFailureResponse($validator);
        }

        /** @var User $user */
        $user = $request->user();

        $certifications = $this->certificationsRepository->saveRawCertifications($user, $request->get('certifications'));

        if (empty($certifications)) {
            $this->jsonResponse(self::STATUS_ERROR, 'There was a problem while saving certifications');
        }

        return $this->jsonResponse('success', 'Successfully updated entries', ['certifications' => $user->certifications]);
    }

    public function getCertifications(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        $certifications = $user->certifications;

        if (!empty($certifications)) {
            return $this->jsonResponse(self::STATUS_SUCCESS, "Success", ['certifications' => $certifications], []);
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, "No certifications found");
        }

    }
}

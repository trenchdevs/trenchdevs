<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * @param string $status
     * @param string $message
     * @param array $errors
     * @return JsonResponse
     */
    protected function jsonResponse(string $status, string $message, array $errors = [])
    {

        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response);
    }

    /**
     * @param Validator $validator
     * @param string $errorMsg
     * @return JsonResponse
     */
    protected function validationFailureResponse(Validator $validator, string $errorMsg = "Validation Error")
    {
        return $this->jsonResponse(self::STATUS_ERROR, $errorMsg, $validator->errors()->all());
    }

}

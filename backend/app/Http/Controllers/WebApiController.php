<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WebApiController extends AuthWebController
{

    public function init(Request $request)
    {

        $site = $this->user->site;
        $siteDetails = $site->attributesToArray();
        $siteDetails['full_domain'] = app()->environment('local') ? "http://{$site->domain}" : "https://{$site->domain}";

        $serverDetails = [
            'time' => date('Y-m-d H:i:s'),
        ];

        if(app()->environment('local')) {
            $serverDetails = array_merge($serverDetails, [
                'origin' => $request->server('HTTP_ORIGIN'),
            ]);
        }

        $userDetails = $this->user->attributesToArray();

        return [
            'site' => $siteDetails,
            'user' => $userDetails,
            'server' => $serverDetails,
        ];
    }

    protected function webApiResponse(callable $fn, string $successMessage = 'Success')
    {

        $response = [
            'status' => 'error',
            'message' => 'There was a problem while processing your request'
        ];

        try {
            DB::beginTransaction();
            $data = $fn();
            DB::commit();

            $response['data'] = $data;
            $response['status'] = 'success';
            $response['message'] = !empty($successMessage) ? $successMessage : 'Success';

        } catch (ValidationException $exception) {
            DB::rollBack();
            $allErrors = $exception->validator->errors()->all(); // all error messages in a single array
            $response['errors'] = $exception->errors();
            $response['errors_all'] = $allErrors;

            $errorMessage = $exception->getMessage();

            if (!empty($allErrors)) {
                $errorMessage = sprintf("$errorMessage %s", implode(' ', $allErrors));
            }

            $response['message'] = $errorMessage;
        } catch (Exception $exception) {
            DB::rollBack();
            $errorMessage = $exception->getMessage();

            if (app()->environment('local')) {
                $className = get_class($exception);
                $errorMessage = "$errorMessage ($className)";
            }

            $response['message'] = $errorMessage;
        }

        return response()->json($response);
    }

}

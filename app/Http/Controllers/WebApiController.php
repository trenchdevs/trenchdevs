<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\DB;

class WebApiController extends AuthWebController
{

    public function init()
    {

        $site = $this->user->site;
        $siteDetails = $site->attributesToArray();
        $siteDetails['full_domain'] = app()->environment('local') ? "http://{$site->domain}" : "https://{$site->domain}";

        $userDetails = $this->user->attributesToArray();

        return [
            'site' => $siteDetails,
            'user' => $userDetails,
            'server' => [
                'time' => date('Y-m-d H:i:s'),
            ]
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

        } catch (Exception $exception) {
            $response['message'] = $exception->getMessage();
            DB::rollBack();
        }

        return response()->json($response);
    }

}

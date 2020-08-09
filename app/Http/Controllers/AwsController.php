<?php

namespace App\Http\Controllers;

use App\AwsSnsLog;
use Illuminate\Http\Request;

class AwsController extends Controller
{
    public function sns(Request $request)
    {
        $sns = new AwsSnsLog();

        $sns->identifier = "sns";
        $sns->headers = json_encode($request->header());
        $sns->raw_json = json_encode($request->json());
        $sns->ip = $request->ip();
        $sns->saveOrFail();

        return $this->jsonResponse(self::STATUS_SUCCESS, 'Success');
    }
}

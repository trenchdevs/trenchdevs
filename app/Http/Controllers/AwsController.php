<?php

namespace App\Http\Controllers;

use App\AwsSnsLog;
use Illuminate\Http\Request;

class AwsController extends Controller
{
    public function sns(Request $request){
        $sns = new AwsSnsLog();
        $sns->identifier = "sns";
        $sns->headers = $request->header();
        $sns->raw_json = $request->all();
        $sns->ip = $request->ip();
        $sns->saveOrFail();
    }
}

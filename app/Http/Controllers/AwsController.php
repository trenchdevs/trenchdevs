<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AwsController extends Controller
{
    public function sns(Request $request){
        var_dump($request->header());
        dd($request->post());
    }
}

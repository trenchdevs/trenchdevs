<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AuthWebController;
use Illuminate\Http\Request;

class AccountsController extends AuthWebController
{

    public function index(){
        abort(404, "Hang Tight. Feature is coming soon.");
    }
}

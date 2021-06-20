<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AwsController;
use App\Http\Controllers\Blogs\PublicBlogsController;
use App\Http\Controllers\EmailTester;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Notifications\EmailPreferencesController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SuperAdmin\CommandsController;
use App\Http\Controllers\Shop\ProductsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

//if (env('APP_ENV') === 'production') {
//    URL::forceScheme('https');
//}

$baseUrl = get_base_url();

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}


Auth::routes(['verify' => true]);

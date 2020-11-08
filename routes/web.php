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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

$baseUrl = env('BASE_URL', 'trenchdevs.org');

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}

// START - Special subdomains here

/**
 * Blogging Domain
 */
Route::domain("blog.{$baseUrl}")->group(function () {
    Route::get('/', [PublicBlogsController::class, 'index'])->name('blogs');
    Route::get('{slug}', [PublicBlogsController::class, 'show']);
});


/**
 * Sample local domain - react
 */
//Route::domain("admin.{$baseUrl}")->group(function () use ($baseUrl) {
//    Route::redirect('login', "http://{$baseUrl}/login");
//    Route::get('/{path?}', function () {
//        return File::get(public_path() . '/fe/index.html');
//    })->middleware(['auth:web']);
//});

// END - Special subdomains here

// START - Portfolio Routes
Route::domain("{username}.{$baseUrl}")->group(function () {
    Route::get('/', [PortfolioController::class, 'show']);
});
// END - Portfolio Routes

Route::get('/', [PublicController::class, 'index'])->name('public.home');

Auth::routes(['verify' => true]);

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);

    // START - users
    Route::get('admin/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('admin/users/upsert', [UsersController::class, 'upsert'])->name('users.upsert');
    Route::post('admin/users/password_reset', [UsersController::class, 'passwordReset'])->name('users.password_reset');
    Route::get('admin/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('admin/users', [UsersController::class, 'index'])->name('users.index');

    Route::post('users/change_password', [UsersController::class, 'changePassword'])->name('users.change_password');
    // End - users

    // START - mailers
    // Route::get('emails/generic', 'EmailTester@genericMail');
    // Announcements
    Route::get('announcements', 'Admin\AnnouncementsController@list')->name('announcements.index');
    Route::get('announcements/create', 'Admin\AnnouncementsController@create')->name('announcements.create');
    Route::post('announcements/announce', 'Admin\AnnouncementsController@announce')->name('announcements.announce');
    // END - mailers

    /**
     * START - portfolio
     */

    // start - user_portfolio_details
    Route::get('portfolio/account', 'Admin\UsersController@account')->name('portfolio.account');
    Route::get('portfolio/edit', 'PortfolioController@edit')->name('portfolio.edit');
    Route::get('portfolio/security', 'PortfolioController@showSecurity')->name('portfolio.security');
    Route::post('portfolio/update', 'PortfolioController@update')->name('portfolio.update');
    Route::post('portfolio/avatar', 'PortfolioController@uploadAvatar')->name('portfolio.avatar');
    Route::post('portfolio/updateBasicInfo', 'PortfolioController@updateBasicInfo')->name('portfolio.updateBasicInfo');
    Route::post('portfolio/background', 'PortfolioController@uploadBackground')->name('portfolio.background');
    Route::get('portfolio/preview', 'PortfolioController@preview');
    // end - user_portfolio_details

    // start - user_experiences
    Route::view('portfolio/experiences/edit', 'portfolio.experiences')->name('portfolio.experiences');
    Route::post('portfolio/experiences/save', 'Portfolio\UserExperiencesController@save')->name('portfolio.experiences.save');
    Route::get('portfolio/experiences/get', 'Portfolio\UserExperiencesController@getExperiences')->name('portfolio.experiences.get');
    // end - user_experiences

    // start - user_degrees
    Route::view('portfolio/degrees/edit', 'portfolio.degrees')->name('portfolio.degrees');
    Route::post('portfolio/degrees/save', 'Portfolio\UserDegreesController@save')->name('portfolio.degrees.save');
    Route::get('portfolio/degrees/get', 'Portfolio\UserDegreesController@getDegrees')->name('portfolio.degrees.get');
    // end - user_degrees

    // start - user_skills
    Route::view('portfolio/skills/edit', 'portfolio.skills')->name('portfolio.skills');
    Route::get('portfolio/skills/get', 'Portfolio\UserSkillsController@getSkills')->name('portfolio.skills.get');
    Route::post('portfolio/skills/save', 'Portfolio\UserSkillsController@save')->name('portfolio.skills.save');
    //  end - user_skills

    // start - user_experiences
    Route::view('portfolio/certifications/edit', 'portfolio.certifications')->name('portfolio.certifications');
    Route::post('portfolio/certifications/save', 'Portfolio\UserCertificationsController@save')->name('portfolio.certifications.save');
    Route::get('portfolio/certifications/get', 'Portfolio\UserCertificationsController@getCertifications')->name('portfolio.certifications.get');
    // end - user_experiences

    // start - user_projects
    Route::view('portfolio/projects/edit', 'portfolio.projects')->name('portfolio.projects');
    Route::post('portfolio/projects/save', 'Portfolio\UserProjectsController@save')->name('portfolio.projects.save');
    Route::get('portfolio/projects/get', 'Portfolio\UserProjectsController@getProjects')->name('portfolio.projects.get');

//    Route::get('projects', 'Portfolio\UserProjectsController@list')->name('projects.list');
    // end - user_projects

    /**
     * END - portfolio
     */

    // start - blogs
    Route::get('blogs', 'Blogs\BlogsController@index')->name('blogs.index');
    Route::get('blogs/upsert/{blogId?}', 'Blogs\BlogsController@upsert')->name('blogs.upsert');
    Route::post('blogs/store', 'Blogs\BlogsController@store')->name('blogs.store');
    Route::get('blogs/show/{id}', 'Blogs\BlogsController@show')->name('blogs.show');
    Route::post('blogs/moderate/{id}', 'Blogs\BlogsController@moderate')->name('blogs.moderate');
    // end - blogs

    // START - shop
    Route::get('shop/products/bulk-upload', [ProductsController::class, 'showBulkUpload'])->name('shop.products.show-bulk-upload');
    Route::post('shop/products/bulk-upload', [ProductsController::class, 'bulkUpload'])->name('shop.products.bulk-upload');
    // END - shop

    // start - profile
    Route::get('profile', [ProfileController::class, 'index']);
    // end - profile

    // start - commands
    Route::get('superadmin/commands', [CommandsController::class, 'index'])->name('superadmin.index');
    Route::post('superadmin/commands', [CommandsController::class, 'command'])->name('superadmin.command');
    // end - commands

    // start - global projects
    Route::get('projects', [ProjectsController::class, 'index'])->name('projects.list');
    // end - global projects


    // START - accounts
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts.index');
    // END - accounts

});

// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents

Route::get('{username}', [PortfolioController::class, 'show']);

// start - public email endpoints
Route::get('emails/unsubscribe', [EmailTester::class, 'test']);
Route::get('emails/testsend', [EmailTester::class, 'testSend']);

Route::get('emails/unsubscribe', [EmailPreferencesController::class, 'showUnsubscribeForm'])->name('notifications.emails.showUnsubscribeForm');
Route::post('emails/unsubscribe', [EmailPreferencesController::class, 'unsubscribe'])->name('notifications.emails.unsubscribe');
// end - public email endpoints
Route::post('aws/sns', [AwsController::class, 'sns']);

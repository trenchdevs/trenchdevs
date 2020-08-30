<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}
Route::get('test', function(){
    \App\Models\EmailQueue::processPending();
});
$baseUrl = env('BASE_URL');

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}

// START - Special subdomains here

Route::domain("blog.{$baseUrl}")->group(function(){
    Route::get('/', 'Blogs\PublicBlogsController@index')->name('blogs');
    Route::get('{slug}', 'Blogs\PublicBlogsController@show');
});

// END - Special subdomains here

// START - Portfolio Routes
Route::domain("{username}.{$baseUrl}")->group(function () {
    Route::get('/','PortfolioController@show');
});
// END - Portfolio Routes

Route::get('/', 'PublicController@index');

Auth::routes(['verify' => true]);

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index');

    // START - users
    Route::get('admin/users/create', 'Admin\UsersController@create')->name('users.create');
    Route::post('admin/users/upsert', 'Admin\UsersController@upsert')->name('users.upsert');
    Route::post('admin/users/password_reset', 'Admin\UsersController@passwordReset')->name('users.password_reset');
    Route::get('admin/users/{id}', 'Admin\UsersController@edit')->name('users.edit');
    Route::get('admin/users', 'Admin\UsersController@index')->name('users.index');

    Route::post('users/change_password', 'Admin\UsersController@changePassword')->name('users.change_password');
    // End - users

    // START - mailers
    // Route::get('emails/generic', 'EmailTester@genericMail');
    // Announcements
    Route::get('announcements/create','Admin\AnnouncementsController@create');
    Route::post('announcements/announce','Admin\AnnouncementsController@announce');
    Route::get('announcements','Admin\AnnouncementsController@list');
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
    Route::post('portfolio/background','PortfolioController@uploadBackground')->name('portfolio.background');
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

    /**
     * END - portfolio
     */

    // start - blogs
    Route::get('blogs', 'Blogs\BlogsController@index')->name('blogs.index');
    Route::get('blogs/upsert/{blogId?}', 'Blogs\BlogsController@upsert')->name('blogs.upsert');
    Route::post('blogs/store', 'Blogs\BlogsController@store')->name('blogs.store');
    // end - blogs

    // START - profile
    Route::get('profile', 'ProfileController@index');
    // END - profile

});

Route::get('{username}', 'PortfolioController@show');
Route::get('emails/test/{view}', 'EmailTester@test');
Route::get('emails/testsend', 'EmailTester@testSend');
Route::post('aws/sns', 'AwsController@sns');

<?php


use App\Modules\Announcements\Http\Controllers\AnnouncementsController;
use App\Modules\Blogs\Http\Controllers\BlogsController;
use App\Modules\Sites\Http\Controllers\AccountsController;
use App\Modules\Users\Http\Controllers\UserCertificationsController;
use App\Modules\Users\Http\Controllers\UserDegreesController;
use App\Modules\Users\Http\Controllers\UserExperiencesController;
use App\Modules\Users\Http\Controllers\UserProjectsController;
use App\Modules\Users\Http\Controllers\UsersController;
use App\Modules\Blogs\Http\Controllers\PublicBlogsController;
use App\Modules\TrenchDevs\Http\Controllers\HomeController;
use App\Modules\Users\Http\Controllers\PortfolioController;
use App\Modules\Users\Http\Controllers\ProfileController;
use App\Modules\Projects\Http\Controllers\ProjectsController;
use App\Modules\TrenchDevs\Http\Controllers\PublicController;
use App\Modules\Products\Http\Controllers\ProductsController;
use App\Modules\SuperAdmin\Http\Controllers\CommandsController;
use App\Modules\Users\Http\Controllers\UserSkillsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$baseUrl = get_base_url(true);

if (empty($baseUrl)) {
    throw new Exception("Base url not found.");
}

Auth::routes(['verify' => true]);

Route::get('blogs', [PublicBlogsController::class, 'index'])->name('public.blogs');

// handler for both blogs and portfolio (w/ blog slug as priority)
//Route::get('{slug}', [PublicController::class, 'show'])->name('public.show');

//Auth::routes();
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


Route::middleware(['auth:web', 'verified'])->prefix('dashboard')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('portal.home');

    // START - users
    Route::get('admin/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('admin/users/upsert', [UsersController::class, 'upsert'])->name('users.upsert');
    Route::post('admin/users/password_reset', [UsersController::class, 'passwordReset'])->name('users.password_reset');
    Route::get('admin/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::get('admin/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('users/change_password', [UsersController::class, 'changePassword'])->name('users.change_password');
    // End - users

    // START - mailers
    // Announcements
    Route::get('announcements', [AnnouncementsController::class, 'list'])->name('announcements.index');
    Route::get('announcements/create', [AnnouncementsController::class, 'create'])->name('announcements.create');
    Route::post('announcements/announce', [AnnouncementsController::class, 'announce'])->name('announcements.announce');
    // END - mailers

    /**
     * START - portfolio
     */

    // start - user_portfolio_details
    Route::get('portfolio/account', [UsersController::class, 'account'])->name('portfolio.account');
    Route::get('portfolio/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::get('portfolio/security', [PortfolioController::class, 'showSecurity'])->name('portfolio.security');
    Route::post('portfolio/update', [PortfolioController::class, 'update'])->name('portfolio.update');
    Route::post('portfolio/avatar', [PortfolioController::class, 'uploadAvatar'])->name('portfolio.avatar');
    Route::post('portfolio/updateBasicInfo', [PortfolioController::class, 'updateBasicInfo'])->name('portfolio.updateBasicInfo');
    Route::post('portfolio/background', [PortfolioController::class, 'uploadBackground'])->name('portfolio.background');
    Route::get('portfolio/preview', [PortfolioController::class, 'preview'])->name('portfolio.preview');
    // end - user_portfolio_details

    // start - user_experiences
    Route::view('portfolio/experiences/edit', 'portfolio.experiences')->name('portfolio.experiences');
    Route::post('portfolio/experiences/save', [UserExperiencesController::class, 'save'])->name('portfolio.experiences.save');
    Route::get('portfolio/experiences/get', [UserExperiencesController::class, 'getExperiences'])->name('portfolio.experiences.get');
    // end - user_experiences

    // start - user_degrees
    Route::view('portfolio/degrees/edit', 'portfolio.degrees')->name('portfolio.degrees');
    Route::post('portfolio/degrees/save', [UserDegreesController::class, 'save'])->name('portfolio.degrees.save');
    Route::get('portfolio/degrees/get', [UserDegreesController::class, 'getDegrees'])->name('portfolio.degrees.get');
    // end - user_degrees

    // start - user_skills
    Route::view('portfolio/skills/edit', 'portfolio.skills')->name('portfolio.skills');
    Route::get('portfolio/skills/get', [UserSkillsController::class, 'getSkills'])->name('portfolio.skills.get');
    Route::post('portfolio/skills/save', [UserSkillsController::class, 'save'])->name('portfolio.skills.save');
    //  end - user_skills

    // start - user_experiences
    Route::view('portfolio/certifications/edit', 'portfolio.certifications')->name('portfolio.certifications');
    Route::post('portfolio/certifications/save', [UserCertificationsController::class, 'save'])->name('portfolio.certifications.save');
    Route::get('portfolio/certifications/get', [UserCertificationsController::class, 'getCertifications'])->name('portfolio.certifications.get');
    // end - user_experiences

    // start - user_projects
    Route::view('portfolio/projects/edit', 'portfolio.projects')->name('portfolio.projects');
    Route::post('portfolio/projects/save', [UserProjectsController::class, 'save'])->name('portfolio.projects.save');
    Route::get('portfolio/projects/get', [UserProjectsController::class, 'getProjects'])->name('portfolio.projects.get');
    // Route::get('projects',[\App\Domains\Users\Http\Controllers\UserProjectsController::class, 'list])->name('projects.list');
    // end - user_projects

    /**
     * END - portfolio
     */

    // start - blogs
    Route::get('blogs', [BlogsController::class, 'index'])->name('blogs.index');
    Route::get('blogs/upsert/{blogId?}', [BlogsController::class, 'upsert'])->name('blogs.upsert');
    Route::post('blogs/store', [BlogsController::class, 'store'])->name('blogs.store');
    Route::get('blogs/show/{id}', [BlogsController::class, 'show'])->name('blogs.show');
    Route::post('blogs/moderate/{id}', [BlogsController::class, 'moderate'])->name('blogs.moderate');
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

Route::get('/', [PublicController::class, 'index'])->name('public.home');
// start - public documents
Route::view('documents/privacy', 'documents.privacy')->name('documents.privacy');
Route::view('documents/tnc', 'documents.tnc')->name('documents.tnc');
// end - public documents

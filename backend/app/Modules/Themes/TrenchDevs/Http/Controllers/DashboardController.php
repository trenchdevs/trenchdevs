<?php

namespace App\Modules\Themes\TrenchDevs\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blogs\Models\Blog;
use App\Modules\Projects\Models\Project;
use App\Modules\Users\Http\Controllers\PortfolioController;
use App\Modules\Users\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $projects = Project::getGlobalProjects();

        return view('welcome', [
            'projects' => $projects,
            'coreDevs' => collect(),
        ]);
    }


    public function show(string $slug)
    {

        $expectsJson = false;

        if (strpos($slug, '.json')) {
            $expectsJson = true;
            $slug = str_replace('.json', '', $slug);
        }

        $blog = Blog::findPublishedBySlug($slug);

        if (!empty($blog)) {
            return $expectsJson ? $blog : view('blogs.public.show', ['blog' => $blog]);
        }

        $customSite = PortfolioController::CUSTOM_URLS[$slug] ?? null;

        if (!empty($customSite)) {
            $this->handleCustomPortfolio($customSite);
        }

        // at this point user has no custom site, use default
        if (!empty($user = User::findByUserName($slug))) {
            $portfolioDetails = $user->getPortfolioDetails();

            if ($expectsJson) {
                return [
                    'portfolio_details' => $user->getPortfolioDetails(),
                    'degrees' => $user->degrees,
                    'experiences' => $user->experiences,
                    'certifications' => $user->certifications,
                ];
            }

            return
                view($portfolioDetails['template'] ?? 'portfolio.show', [
                    'user' => $user,
                    'portfolio_details' => $user->getPortfolioDetails(),
                ]);
        }

        abort(404);
    }

    private function handleCustomPortfolio(string $site)
    {

        if (empty($site)) {
            abort(404);
        }

        return view('portfolio.custom', [
            'site' => $site
        ]);
    }

}

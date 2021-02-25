<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Projects\Project;
use App\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {

        $projects = Project::getGlobalProjects();
        $coreDevs = User::query()
            ->whereIn('id', [
                2,
                3,
                4,
                11,
            ])
            ->get();

        return view('welcome', [
            'projects' => $projects,
            'coreDevs' => $coreDevs,
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

        /**
         * at this point user has no custom site, use default
         */
        $user = User::findByUserName($slug);

        if ($user) {
            $portfolioDetails = $user->getPortfolioDetails();

            return $expectsJson ?
                [
                    'portfolio_details' => $user->getPortfolioDetails(),
                    'degrees' => $user->degrees,
                    'experiences' => $user->experiences,
                    'certifications' => $user->certifications,
                ]
                :
                view($portfolioDetails->portfolio_view ?: 'portfolio.show', [
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

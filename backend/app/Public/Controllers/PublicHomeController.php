<?php

namespace App\Public\Controllers;

use App\Domains\Blogs\Models\Blog;
use App\Domains\Blogs\Repositories\BlogsRepository;
use App\Domains\Sites\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PublicHomeController extends Controller
{

    public function index(): View
    {
        $blogsRepo = new BlogsRepository();
        return $this->siteViewOrDefault('public.home', [
            'blogs' => $blogsRepo->all([]),
        ]);
    }

    public function about(): View
    {
        return $this->siteViewOrDefault('public.about');
    }
}

<?php

namespace App\Domains\Blogs\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Domains\Blogs\Models\Blog;
use App\Domains\Blogs\Repositories\BlogsRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBlogsController extends Controller
{
    /**
     * @param Request $request
     * @param BlogsRepository $blogsRepository
     * @return Application|Factory|JsonResponse|View
     */
    public function index(Request $request, BlogsRepository $blogsRepository)
    {
        $username = $request->get('username');

        $blogs = $blogsRepository->all(['username' => $username]);

        if ($request->expectsJson()) {
            return response()->json($blogs);
        }

        return view('blogs.public.index', ['blogs' => $blogs]);
    }

    public function show($slugOrId){

        // todo: implement id in future
        $blog = Blog::findPublishedBySlug($slugOrId);

        if (empty($blog)) {
            abort(404);
        }

        return view('blogs.public.show', [
            'blog' => $blog,
        ]);
    }
}
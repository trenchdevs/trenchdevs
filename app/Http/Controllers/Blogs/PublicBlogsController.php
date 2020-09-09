<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBlogsController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {

        $username = $request->get('username');

        $query = Blog::query();

        $query = $query->where('blogs.status', '=', Blog::DB_STATUS_PUBLISHED)
            ->where('blogs.moderation_status', '=', Blog::DB_MODERATION_STATUS_APPROVED)
            ->where('blogs.publication_date', '<=', mysql_now())
            ->whereNotNull('publication_date')
            ->orderBy('blogs.created_at', 'DESC')
            ->orderBy('blogs.id', 'DESC');

        if (!empty($username)) {
            $query = $query->join('users', 'users.id', '=', 'blogs.user_id', 'inner')
                ->where('users.username', '=', $username);
        }

        $blogs = $query->paginate(6);

        return view('blogs.public.index', [
            'blogs' => $blogs
        ]);
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

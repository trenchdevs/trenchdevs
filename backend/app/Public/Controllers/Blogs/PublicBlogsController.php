<?php

namespace App\Public\Controllers\Blogs;

use App\Domains\Blogs\Models\Blog;
use App\Domains\Sites\Models\Tag;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublicBlogsController extends Controller
{
    public function index(Request $request): View
    {

        $blogs = Blog::query()
            ->selectRaw('DISTINCT blogs.*')
            ->when(!empty($q = $request->input('q')), function(Builder $query) use ($q){
                $query->where('blogs.title', 'like', "%$q%");
            })
            ->when(!empty($tagId = $request->input('tid', "")), function (Builder $query) use ($tagId) {
                $query->join('blog_tags', 'blog_tags.blog_id', '=', 'blogs.id');
                $query->join('tags', 'tags.id', '=', 'blog_tags.tag_id');
                $query->where('tags.id', '=', $tagId);
            });

        return $this->siteViewOrDefault('public.blogs.index', [
            'tag'   => Tag::query()->find($tagId),
            'blogs' => $blogs->simplePaginate()
        ]);
    }

    public function details(string $slug){

        return $this->siteViewOrDefault('public.blogs.details', [
            'blog' =>  Blog::query()->where('slug', '=', $slug)->first(),
        ]);
    }
}
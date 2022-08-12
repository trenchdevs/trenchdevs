<?php

namespace App\Public\Controllers\Blogs;

use App\Modules\Blogs\Models\Blog;
use App\Modules\Sites\Models\Tag;
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
            'tag'   => $tagId ? Tag::query()->find($tagId) : Tag::query()->newModelInstance(),
            'blogs' => $blogs->simplePaginate()
        ]);
    }

    public function details(string $slug){

        return $this->siteViewOrDefault('public.blogs.details', [
            'blog' =>  Blog::query()->where('slug', '=', $slug)->first(),
        ]);
    }
}

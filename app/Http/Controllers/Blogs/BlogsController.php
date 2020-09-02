<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogsController extends AuthWebController
{

    public function middlewareOnConstructorCalled(): void
    {
        if (!$this->user->hasAccessToBlogs()) {
            abort(403, "Blogs feature not enabled in your account");
        }
    }

    public function index(Request $request)
    {
        $me = $request->get('me');

        /** @var User $user */
        $user = $request->user();

        $blogs = Blog::query();

        if (!empty($me)) {
            $blogs->where('user_id', $user->id);
        }

        $blogs = $blogs->orderBy('id', 'desc')
            ->paginate(6);

        return view('blogs.index', [
            'blogs' => $blogs,
        ]);
    }

    public function upsert($blogId = null, Request $request)
    {

        $blog = new Blog();

        if (!empty($blogId)) {
            /** @var User $loggedInUser */
            $loggedInUser = $request->user();

            $blog = Blog::find($blogId);
            if (!$this->isLoggedInUserAdmin() &&
                $blog->user_id !== $loggedInUser->id) {
                abort(403, "You are not allowed to update this resource");
            }
        }

        return view('blogs.upsert', [
            'blog' => $blog,
        ]);
    }

    public function store(Request $request)
    {

        $id = $request->get('id');

        $editMode = !empty($id);

        // todo: on update unique
        $this->validate($request, [
            'title' => ['required', 'max:255', Rule::unique('blogs')->ignore($id)],
            'slug' => ['required', 'max:255', Rule::unique('blogs')->ignore($id)],
            'status' => 'required|in:draft,published',
            'primary_image_url' => 'required:max:512',
            'tagline' => 'required|max:255',
            'markdown_contents' => 'required|max:50000', // can be changed later on if needed more
        ]);

        /** @var User $user */
        $user = $request->user();

        $data = $request->all();
        $data['user_id'] = $user->id;

        if ($editMode) {
            $blog = Blog::findOrFail($id);
        } else {
            $blog = new Blog;
        }

        $blog->fill($data);
        $blog->saveOrFail();

        // todo: insert ignore tags

        $message = 'Successfully ' . ($editMode ? 'updated' : 'created') . ' the blog entry "' . $blog->title . '".';
        return redirect(route('blogs.index'))->with('message', $message);

    }
}

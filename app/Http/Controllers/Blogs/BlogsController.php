<?php

namespace App\Http\Controllers\Blogs;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\EmailQueue;
use App\Repositories\BlogsRepository;
use App\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class BlogsController extends AuthWebController
{

    /** @var BlogsRepository */
    private $blogsRepo;

    public function middlewareOnConstructorCalled(): void
    {
        if (!$this->user->hasAccessToBlogs()) {
            abort(403, "Blogs feature not enabled in your account");
        }

        $this->blogsRepo = new BlogsRepository($this->user);
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

        $blogStatistics = $this->blogsRepo->getStatistics();

        return view('blogs.index', [
            'blogs' => $blogs,
            'blog_statistics' => $blogStatistics,
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

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $id = $request->get('id');

        $editMode = !empty($id);

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

        $blog = $this->blogsRepo->storeBlog($user, $request->all());

        $message = 'Successfully ' . ($editMode ? 'updated' : 'created') . ' the blog entry "' . $blog->title . '".';
        return redirect(route('blogs.index'))->with('message', $message);

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function moderate(Request $request)
    {
        $this->validate($request, [
            'moderation_status' => 'required',
            'moderation_notes' => 'required|max:1000|min:8',
        ]);

        try {

            /** @var Blog $blog */
            $blog = Blog::query()->findOrFail($request->post('id'));

            if (!$this->blogsRepo->moderateOrFail($blog, $request->post())) {
                throw new Exception("There was a problem while moderating blog entry");
            }

            $successMessage = sprintf('Successfully moderated %s. Moderation status changed to "%s"', $blog->title, $blog->moderation_status);

            return back()->with('message', $successMessage);

        } catch (Throwable $exception) {
            return back()->withErrors([$exception->getMessage()])->withInput();
        }
    }

    public function show(int $id, Request $request)
    {

        /** @var Blog $blog */
        $blog = Blog::query()->findOrFail($id);

        return view('blogs.public.show', [
            'blog' => $blog,
        ]);
    }
}

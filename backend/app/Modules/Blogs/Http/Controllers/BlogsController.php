<?php

namespace App\Modules\Blogs\Http\Controllers;

use App\Http\Controllers\AuthWebController;
use App\Modules\Blogs\Models\Blog;
use App\Modules\Blogs\Repositories\BlogsRepository;
use App\Modules\Users\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Inertia\Response;
use Throwable;

class BlogsController extends AuthWebController
{

    /**
     * @var BlogsRepository
     */
    private BlogsRepository $blogsRepo;

    public function middlewareOnConstructorCalled(): void
    {
        if (!$this->user->hasAccessToBlogs()) {
            abort(403, "Blogs feature not enabled in your account");
        }

        $this->blogsRepo = new BlogsRepository($this->user);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function displayBlogs(Request $request): Response
    {
        return $this->inertiaRender('Blogs/BlogsList', [
            'data' => Blog::query()
                ->when(!empty($request->get('me')), fn(Builder $query) => $query->where('user_id', '=', $request->user()->id ?? null))
                ->orderBy('id', 'desc')
                ->paginate(1)
        ]);
    }

    /**
     * @param int|null $id
     * @return Response
     * @throws Exception
     */
    public function upsertForm(int $id = null): Response
    {
        $data = [];

        if (is_numeric($id)) {
            $blog = Blog::query()->find($id);
            $data = $blog->attributesToArray();
            $data['tags'] = $blog->tags->pluck('tag_name')->implode(',');
        }

        return $this->inertiaRender('Blogs/BlogUpsert', [
            'blog' => $data,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function upsertBlog(Request $request): RedirectResponse
    {

        $id = $request->get('id');

        $editMode = !empty($id);

        $this->validate($request, [
            'title' => ['required', 'max:255', Rule::unique('blogs')->ignore($id)],
            'slug' => ['required', 'max:255', Rule::unique('blogs')->ignore($id)],
            'status' => 'required|in:draft,published',
            'primary_image_url' => 'required:max:512|url',
            'tagline' => 'required|max:255',
            'markdown_contents' => 'required|max:50000', // can be changed later on if needed more
            'publication_date' => 'required|date',
            'tags' => 'required|max:1000',
        ]);

        /** @var User $user */
        $user = $request->user();

        $blog = $this->blogsRepo->storeBlog($user, $request->all());

        Session::flash('message', 'Successfully ' . ($editMode ? 'updated' : 'created') . ' the blog entry "' . $blog->title . '".');
        return redirect(site_route('dashboard.blogs'));

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function moderate(Request $request): RedirectResponse
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

    public function preview(int $id): View
    {

        /** @var Blog $blog */
        $blog = Blog::query()->findOrFail($id);

        return view('blogs.public.show', [
            'blog' => $blog,
        ]);
    }
}

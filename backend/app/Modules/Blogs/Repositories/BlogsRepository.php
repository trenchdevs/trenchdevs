<?php

namespace App\Modules\Blogs\Repositories;

use App\Modules\Blogs\Models\Blog;
use App\Modules\Blogs\Models\Tag;
use App\Modules\Emails\Models\EmailLog;
use App\Modules\Users\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;

class BlogsRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * BlogsRepository constructor.
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    const VALID_MODERATION_STATUSES = [
        Blog::DB_MODERATION_STATUS_APPROVED,
        Blog::DB_MODERATION_STATUS_REJECTED,
        Blog::DB_MODERATION_STATUS_PENDING,
    ];

    /**
     * @param array $filters
     * @return Paginator
     */
    public function all(array $filters): Paginator
    {
        $query = Blog::query()
            ->withoutGlobalScopes()
            ->selectRaw('blogs.*')
            ->join('users as u', 'u.id', '=', 'blogs.user_id', 'left')
            ->where('blogs.status', '=', Blog::DB_STATUS_PUBLISHED)
            ->where('blogs.site_id', '=', site()->id)
            ->where('blogs.moderation_status', '=', Blog::DB_MODERATION_STATUS_APPROVED)
            ->where('blogs.publication_date', '<=', date_now())
            ->whereNotNull('blogs.publication_date')
            ->orderBy('blogs.created_at', 'DESC')
            ->orderBy('blogs.id', 'DESC');

        foreach ($filters as $filterKey => $filterValue) {

            switch ($filterKey) {
                case 'external_id':
                    if (!empty($filterValue) && is_string($filterValue)) {
                        $query = $query->where('u.external_id', '=', $filterValue);
                    }
                    break;
                default:
                    break;
            }
        }

        return $query->simplePaginate(6);
    }

    /**
     * @param Blog $blog
     * @param array $moderationData
     * @return bool
     * @throws Throwable
     */
    public function moderateOrFail(Blog $blog, array $moderationData): bool
    {
        $moderationData = $this->validateAndExtractModerationData($blog, $moderationData);

        $moderationData['moderated_by'] = $this->user->id;
        $moderationData['moderated_at'] = date('Y-m-d H:i:s');

        $blog->fill($moderationData);

        return $blog->saveOrFail();
    }

    /**
     * @param Blog $blog
     * @param array $moderationData
     * @return array
     * @throws Exception
     */
    private function validateAndExtractModerationData(Blog $blog, array $moderationData): array
    {

        $newModerationStatus = $moderationData['moderation_status'] ?? null;
        $moderationNotes = $moderationData['moderation_notes'] ?? null;

        if (!$this->user->isAdmin()) {
            throw new Exception("You don't have permission to moderate blogs");
        }

        if (!in_array($newModerationStatus, self::VALID_MODERATION_STATUSES)) {
            throw new Exception("Invalid status {$newModerationStatus} given");
        }

        if ($newModerationStatus === $blog->moderation_status) {
            throw new Exception("Moderation status is already in {$newModerationStatus} state.");
        }

        if (empty($moderationNotes) || strlen($moderationNotes) < 8) {
            throw new Exception("Moderation notes must be at least 8 characters");
        }


        return Arr::only($moderationData, ['moderation_status', 'moderated_by', 'moderated_at', 'moderation_notes']);
    }

    /**
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => Blog::query()->count(),
            'status_draft' => Blog::query()->where('status', Blog::DB_STATUS_DRAFT)->count(),
            'status_published' => Blog::query()->where('status', Blog::DB_STATUS_PUBLISHED)->count(),
            'moderation_pending' => Blog::query()
                ->where('moderation_status', Blog::DB_MODERATION_STATUS_PENDING)
                ->count(),
            'moderation_approved' => Blog::query()
                ->where('moderation_status', Blog::DB_MODERATION_STATUS_APPROVED)
                ->count(),
            'moderation_rejected' => Blog::query()
                ->where('moderation_status', Blog::DB_MODERATION_STATUS_REJECTED)
                ->count(),
        ];
    }

    /**
     * @param User $loggedInUser
     * @param array $data
     * @return Blog
     * @throws ValidationException
     */
    public function storeBlog(User $loggedInUser, array $data): Blog
    {

        try {

            DB::beginTransaction();

            $id = $data['id'] ?? null;
            $editMode = !empty($id);

            // 1. Save actual Blog entry
            if ($editMode) {

                $blog = Blog::query()->findOrFail($id);

                if (!$loggedInUser->isBlogModerator()) {
                    // User updates content, let moderators re-moderate the blog again
                    $data['moderation_status'] = Blog::DB_MODERATION_STATUS_PENDING;
                }


            } else {

                $data['user_id'] = $loggedInUser->id;
                $data['moderation_status'] = Blog::DB_MODERATION_STATUS_PENDING;

                if ($loggedInUser->isBlogModerator()) {
                    $data['moderation_status'] = Blog::DB_MODERATION_STATUS_APPROVED;
                    $data['moderation_notes'] = "Blog is pre-approved by the system";
                    $data['moderated_at'] = date_now();
                    $data['moderated_by'] = $loggedInUser->id;
                }

                $blog = new Blog;
            }

            $data['site_id'] = site()->id;
            $blog->fill($data);
            $blog->saveOrFail();

            // 2. Save Blog tags
            $tags = $data['tags'] ?? null;

            if (empty($tags) || !is_string($tags)) {
                throw new InvalidArgumentException("Tag(s) csv required (eg: 'php, git, first-post')");
            }

            $tags = trim($tags, "\t\n\r\0\x0B,");
            $tagsArr = explode(',', $tags);

            if (empty($tagsArr)) {
                throw new InvalidArgumentException("Tag(s) csv required (eg: 'php, git, first-post')");
            }

            $tagIds = [];
            foreach ($tagsArr as $tagName) {
                $sanitizedTag = trim(strtolower($tagName));

                if (empty($sanitizedTag)) {
                    continue; // skipping these
                }

                $tag = Tag::findOrNewByName($sanitizedTag); // throws on error
                $tagIds[] = $tag->id;
            }

            if (empty($tagIds)) {
                throw new InvalidArgumentException("Unable to save tags.");
            }

            // add / remove tags from pivot table (blog_tags)
            $blog->tags()->sync($tagIds);

            // 3. Send emails to moderator (if applicable)
            // @tag: v2.0.1
            //if (!$loggedInUser->isBlogModerator() && $blog->moderation_status === Blog::DB_MODERATION_STATUS_PENDING) {
            //    $this->sendModerationEmails($blog);
            // }

            DB::commit();


        } catch (Throwable $throwable) {

            DB::rollBack();
            throw ValidationException::withMessages([
                'errors' => [$throwable->getMessage()]
            ]);
        }

        return $blog;
    }

    /**
     * Send emails to moderator
     * @param Blog $blog
     * @throws Throwable
     */
    private function sendModerationEmails(Blog $blog): void
    {

        /** @var User[] $moderators */
        $moderators = User::getBlogModerators();

        if (!empty($moderators)) {

            $userFullName = $this->user->name();
            $blogPostsLink = get_site_url() . '/blogs';
            $message = "{$userFullName} has created/modified blog post \"{$blog->title}\" and is ready for moderation <br/>"
                . "<br/>  Please visit the following link to moderate the blog post: "
                . "<a href='{$blogPostsLink}'>{$blogPostsLink}</a>";

            foreach ($moderators as $moderator) {

                $viewData = [
                    'name' => $moderator->name(),
                    'email_body' => $message,
                ];

                EmailLog::enqueue(
                    $moderator->email,
                    "TrenchDevsAdmin: Blog Entry \"{$blog->title}\" Moderation",
                    $viewData,
                    'emails.generic'
                );
            }
        }
    }


}

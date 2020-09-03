<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\EmailQueue;
use App\User;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class BlogsRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * BlogsRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    const VALID_MODERATION_STATUSES = [
        Blog::DB_MODERATION_STATUS_APPROVED,
        Blog::DB_MODERATION_STATUS_REJECTED,
        Blog::DB_MODERATION_STATUS_PENDING,
    ];

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

        $blog = null;

        try {

            DB::beginTransaction();

            $id = $data['id'] ?? null;
            $editMode = !empty($id);

            $data['user_id'] = $loggedInUser->id;

            /**
             * 1. Save Blog
             */
            if ($editMode) {

                if (!$loggedInUser->isBlogModerator()) {
                    // User updates content, let moderators re-moderate the blog again
                    $data['moderation_status'] = Blog::DB_MODERATION_STATUS_PENDING;
                }

                $blog = Blog::query()->findOrFail($id);

            } else {

                if ($loggedInUser->isBlogModerator()) {
                    $data['moderation_status'] = Blog::DB_MODERATION_STATUS_APPROVED;
                    $data['moderation_notes'] = "Blog is pre-approved by the system";
                    $data['moderated_at'] = mysql_now();
                    $data['moderated_by'] = $loggedInUser->id;
                }

                $blog = new Blog;
            }

            $blog->fill($data);
            $blog->saveOrFail();

            /**
             * todo:
             * 2. Save Blog Tags
             */

            /**
             * 3. Send emails to moderator (if applicable)
             */
            if (!$loggedInUser->isBlogModerator() && $blog->moderation_status === Blog::DB_MODERATION_STATUS_PENDING) {
                $this->sendModerationEmails($blog);
            }


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
    private function sendModerationEmails(Blog $blog)
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

                EmailQueue::queue(
                    $moderator->email,
                    "TrenchDevs: Blog Entry \"{$blog->title}\" Moderation",
                    $viewData,
                    'emails.generic'
                );
            }
        }
    }


}

<?php

namespace App\Repositories;

use App\Models\Blog;
use App\User;
use Exception;
use Illuminate\Support\Arr;
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


}

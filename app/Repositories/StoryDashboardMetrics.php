<?php

namespace App\Repositories;

use App\Models\ProductReaction;
use App\Models\Stories\StoryActionLog;
use App\User;
use Illuminate\Support\Facades\DB;

class StoryDashboardMetrics
{
    private $owner = null;

    public static function instance(): self
    {
        return new self();
    }

    public function setOwner(User $owner)
    {
        $this->owner = $owner;
        return $this;
    }

    public function storyVisitsCount(array $filters = []): int
    {

        $query = StoryActionLog::query()
            ->selectRaw('COUNT(1) AS total_count')
            ->from('story_action_logs AS sal')
            ->join('stories AS s', 's.id', '=', 'sal.story_id', 'inner');

        if ($this->owner) {
            $query->where('owner_user_id', $this->owner->id);
        }

        foreach ($filters as $filterKey => $filterVal) {
            switch ($filterKey) {
                case 'date_greater_than':
                    $query->where('created_at', $filterVal);
                    break;
            }
        }


        return $query->first()->total_count ?? 0;
    }


    public function reactionTotal(string $reaction)
    {

        $query = ProductReaction::query()
            ->selectRaw('COUNT(1) AS total_count')
            ->from('product_reactions AS pr')
            ->join('products AS p', 'p.id', '=', 'pr.product_id', 'inner')
            ->where('pr.reaction', $reaction);

        if ($this->owner) {
            $query->where('p.owner_user_id', '=', $this->owner->id);
        }

        return $query->first()->total_count ?? 0;
    }

}

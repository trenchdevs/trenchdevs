<?php

namespace App\Domains\Stories\Repositories;

use App\Domains\Products\Models\ProductReaction;
use App\Domains\Stories\Models\Story;
use App\Domains\Stories\Models\StoryActionLog;
use App\Domains\Stories\Models\StoryResponse;
use App\Domains\Products\Models\Product;
use App\Domains\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

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

        $this->appendOwnerFilter($query);

        foreach ($filters as $filterKey => $filterVal) {
            switch ($filterKey) {
                case 'date_greater_than':
                    $query->where('sal.created_at', '>', $filterVal);
                    break;
                default:
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

        $query = $this->appendOwnerFilter($query);

        return $query->first()->total_count ?? 0;
    }

    public function productMetrics(): array
    {

        $rawSelect = [
            'products.id',
            'products.name',
            'products.sku',
            'pr.reaction',
            'count(pr.id) AS total_reactions',
        ];

        $query = Product::query()->selectRaw(implode(',', $rawSelect))
            ->from('products')
            ->join('product_reactions AS pr', 'products.id', '=', 'pr.product_id', 'left')
            ->groupBy('products.id', 'pr.reaction')
            ->orderBy('total_reactions', 'desc');

        $query = $this->appendOwnerFilter($query);

        if (empty($results = $query->get()->toArray())) {
            return [];
        }

        $formattedResults = [];

        foreach ($results as $result) {

            $productId = $result['id'];

            if (!isset($formattedResults[$productId])) {
                $formattedResults[$productId] = [
                    'name' => $result['sku'],
                    'like' => 0,
                    'dislike' => 0,
                ];
            }

            if (!empty($result['total_reactions'])) {
                $formattedResults[$productId][$result['reaction']] = $result['total_reactions'];
            }
        }

        return array_values($formattedResults);
    }

    private function appendOwnerFilter(Builder $query, string $ownerColumn = 'owner_user_id')
    {

        if ($this->owner) {
            $query->where($ownerColumn, $this->owner->id);
        }

        return $query;

    }

    public function storiesActiveTotal(): int
    {
        return $this->appendOwnerFilter(Story::query())->count();
    }

    public function productsTotal()
    {
        return $this->appendOwnerFilter(Product::query())->count();
    }

    public function storyResponsesTotal(array $filters = [])
    {
        $query = StoryResponse::query()
            ->join('stories', 'story_responses.story_id', '=', 'stories.id');

        foreach ($filters as $filterKey => $filterVal) {
            switch ($filterKey) {
                case 'date_greater_than':
                    $query->where('story_responses.created_at', '>', $filterVal);
                    break;
                default:
                    break;
            }
        }

        $query = $this->appendOwnerFilter($query, 'story_responses.owner_user_id');

        return $query->count();
    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Stories\Story;
use App\Models\Stories\StoryActionLog;
use App\Models\Stories\StoryResponse;
use App\Product;
use App\Repositories\StoryDashboardMetrics;
use App\User;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ApiStories extends ApiController
{

    /**
     * Create / Update a story
     * @return JsonResponse
     */
    public function upsert()
    {
        return $this->responseHandler(function () {
            /**
             * @var User $user
             * @var Story $story
             */

            $request = request();
            $id = $request->id ?? null;

            $this->validate($request, [
                'title' => 'required|string|max:255',
                'is_active' => 'required|in:1,0',
                'description' => 'string|max:512',
            ]);

            $user = auth()->user();

            $updatedMode = false;

            if (!empty($id)) {

                $updatedMode = true;

                if (!$story = Story::query()->find($id)) {
                    throw new ErrorException("Story not found");
                }

                if (!$story->hasAccess($user)) {
                    throw new ErrorException("Forbidden");
                }

            } else {
                $story = new Story();
            }

            $data = $request->all();
            $data['owner_user_id'] = $user->id;
            $data['slug'] = md5(time() . $user->id . rand(0, 1000));

            $story->fill($data);
            $story->save();

            $verbiage = $updatedMode ? "updated" : "added a new";

            $this->setSuccessMessage("Successfully {$verbiage} product.");

            return $story;
        });
    }

    /**
     * Returns all stories for currently logged in users
     * @return JsonResponse
     */
    public function all()
    {
        return $this->responseHandler(function () {
            return Story::query()
                ->where('owner_user_id', auth()->id())
                ->paginate();
        });
    }

    public function one($storyId)
    {
        return $this->responseHandler(function () use ($storyId) {

            if (empty($storyId) || !is_numeric($storyId)) {
                throw new InvalidArgumentException("Story id invalid");
            }

            /** @var Story $story */
            $story = Story::query()->findOrFail($storyId ?? null);

            if (!$story->hasAccess(auth()->user())) {
                throw new InvalidArgumentException("Forbidden..");
            }

            $addedProducts = $story->products;

            return [
                'story' => $story,
                'added_products' => $addedProducts,
                // get my products that have not been added yet
                'products' => Product::query()
                    ->where('products.owner_user_id', auth()->id())
                    ->whereNotIn('products.id', $addedProducts->pluck('id'))
                    ->get(),
            ];

        });
    }


    public function slug($slug)
    {

        return $this->responseHandler(function () use ($slug) {

            if (empty($slug)) {
                throw new InvalidArgumentException("Slug invalid");
            }

            /** @var Story $story */
            $story = Story::query()->where('slug', $slug)->first();

            if (!$story) {
                throw new InvalidArgumentException("Sorry, can't seem find what you're looking for..");
            }

            if ($story->is_active != 1) {
                throw new InvalidArgumentException("Story is deactivated by owner..");
            }

            /** @var Product[] $storyProducts */
            $storyProducts = $story->products;


            if (!$storyProducts || $storyProducts->isEmpty()) {
                throw new InvalidArgumentException("No products found for this story...");
            }

            $metaJson = request_meta(true);

            StoryActionLog::query()->create([
                'story_id' => $story->id,
                'hash' => md5("$story->id|$metaJson"),
                'meta_json' => $metaJson,
            ]);

            return [
                'story' => $story,
                'products' => $storyProducts,
            ];
        });

    }

    public function metrics()
    {

        return $this->responseHandler(function () {
            /**
             * story_visits_total
             * story_visits_past_month
             * likes_total
             * unlikes_total
             * stories_active_total
             * products_active_total
             */

            /** @var User $user */
            $user = auth()->user();

            $metrics = StoryDashboardMetrics::instance()->setOwner($user);

            $pastMonthFilter = [
                'date_greater_than' => date('Y-m-d H:i:s', strtotime('-1 month'))
            ];

            return [
                'story_visits_total' => $metrics->storyVisitsCount(),
                'story_visits_past_month' => $metrics->storyVisitsCount($pastMonthFilter),
                'likes_total' => $metrics->reactionTotal('like'),
                'unlikes_total' => $metrics->reactionTotal('dislike'),
                'stories_active_total' => $metrics->storiesActiveTotal(),
                'products_active_total' => $metrics->productsTotal(),
                'story_responses_total' => $metrics->storyResponsesTotal(),
                'story_responses_past_month' => $metrics->storyResponsesTotal($pastMonthFilter),

                // graphs
                'product_metrics' => $metrics->productMetrics(),
            ];

        });
    }


}

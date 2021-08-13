<?php

namespace App\Domains\Stories\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\Domains\Stories\Models\Story;
use App\Domains\Products\Models\Product;
use App\Domains\Users\Models\User;
use ErrorException;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class ProductStoriesController extends ApiController
{


    /**
     * @return JsonResponse
     */
    public function addProductsToStories()
    {

        return $this->responseHandler(function () {
            /**
             * Associate all product id arrays (product_ids) to a story (story_id)
             * @var Story $story
             * @var User $user
             */
            $requestArr = request()->all();

            if (!$storyId = $requestArr['story_id'] ?? null) {
                throw new InvalidArgumentException("Story id is required");
            }

            if (!$story = Story::query()->find($storyId)) {
                throw new InvalidArgumentException("Unable to find story");
            }

            $user = auth()->user();

            if (!$story->hasAccess($user)) {
                throw new InvalidArgumentException("Forbidden");
            }

            $productIds = $requestArr['product_ids'] ?? [];

            if (empty($productIds)) {
                $story->products()->detach();
            } else {
                // validate if product ids belong to the same user
                $validatedProductIds = Product::query()
                    ->where('owner_user_id', $user->id)
                    ->whereIn('id', $productIds)
                    ->get()
                    ->pluck('id')
                    ->toArray();

                if (!empty(array_diff($productIds, $validatedProductIds))) { // expected []
                    throw new ErrorException("Forbidden.");
                }

                $story->products()->sync($productIds);
            }

        });

    }
}

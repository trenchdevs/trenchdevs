<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Stories\Story;
use App\User;
use ErrorException;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class ApiProductStories extends ApiController
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
             */
            $requestArr = request()->all();

            if (!$storyId = $requestArr['story_id'] ?? null) {
                throw new InvalidArgumentException("Story id is required");
            }

            if (!$story = Story::query()->find($storyId)) {
                throw new InvalidArgumentException("Unable to find story");
            }

            /** @var User $user */
            $user = auth()->user();

            if (!$story->hasAccess($user)) {
                throw new InvalidArgumentException("Forbidden");
            }

            if (!$productIds = $requestArr['product_ids'] ?? []) {
                throw new InvalidArgumentException("Product Ids must be an array of ids");
            }

            // validate if product ids belong to the same user
            $validatedProductIds = $story->products()
                ->select('products.id')
                ->whereIn('products.id', $productIds)
                ->where('products.owner_user_id', $user->id)
                ->pluck('id')
                ->toArray();

            if (!array_diff($productIds, $validatedProductIds)) { // expected 0
                throw new ErrorException("Forbidden");
            }

            $story->products()->sync($productIds);
        });

    }
}

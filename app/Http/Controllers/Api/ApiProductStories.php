<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Stories\Story;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class ApiProductStories extends ApiController
{


    /**
     * @return JsonResponse
     */
    public function addProductsToStories (){

        return $this->responseHandler(function(){
            /**
             * Associate all product id arrays (product_ids) to a story (story_id)
             * @var Story $story
             */
            $requestArr = request()->all();

            if (!$storyId = $requestArr['story_id'] ?? null ) {
                throw new InvalidArgumentException("Story id is required");
            }

            if (!$story = Story::query()->find($storyId)) {
                throw new InvalidArgumentException("Unable to find story");
            }

            if (!$story->hasAccess(auth()->user())) {
                throw new InvalidArgumentException("Forbidden");
            }

            if (!$productIds = $requestArr['product_ids'] ?? []) {
                throw new InvalidArgumentException("Product Ids must be an array of ids");
            }

            // todo: validate product ids

            $story->products()->attach($productIds);
        });

    }
}

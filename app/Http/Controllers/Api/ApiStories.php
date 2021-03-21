<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Stories\Story;
use App\Product;
use App\User;
use ErrorException;
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

    public function one(int $storyId)
    {
        return $this->responseHandler(function () use ($storyId) {

            /** @var Story $story */
            $story = Story::query()->with('products')->findOrFail($storyId ?? null);

            if (!$story->hasAccess(auth()->user())) {
                throw new InvalidArgumentException("Forbidden..");
            }

            return [
                'story' => $story,
                'added_products' => $story->products,
                'products' => DB::table('products AS p')
                    ->join('product_stories AS ps', 'p.id', '=', 'ps.product_id', 'LEFT')
                    ->join('stories AS s', 's.id', '=', 'ps.story_id', 'LEFT')
                    ->whereNull('s.id')
                    ->get()
            ];
        });
    }

}

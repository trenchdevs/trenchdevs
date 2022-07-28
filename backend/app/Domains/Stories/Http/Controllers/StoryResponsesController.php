<?php

namespace App\Domains\Stories\Http\Controllers;

use App\Http\Controllers\Auth\ApiController;
use App\Domains\Stories\Models\Story;
use App\Domains\Stories\Models\StoryResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class StoryResponsesController extends ApiController
{

    /**
     * Returns all stories for currently logged in users
     * @return JsonResponse
     */
    public function all()
    {
        return $this->responseHandler(function () {
            return StoryResponse::query()
                ->join('stories', 'story_responses.story_id', '=', 'stories.id')
                ->select('story_responses.*', 'stories.title', 'stories.slug')
                ->where('story_responses.owner_user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate();
        });
    }

    public function store()
    {

        return $this->responseHandler(function () {

            $request = request();

            $validator = Validator::make($request->all(), StoryResponse::getValidationRules(), StoryResponse::getCustomValidationMessages());

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            if (!$story = Story::query()->find($request->input('story_id'))) {
                throw new InvalidArgumentException("Story not found.");
            }

            if (!$story->is_active) {
                throw new InvalidArgumentException("Story is inactive.");
            }

            $metaJson = request_meta(true);

            return StoryResponse::query()->create([
                'story_id' => $story->id,
                'owner_user_id' => $story->owner_user_id,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'response_text' => $request->response_text,
                'hash' => md5("$story->id|$metaJson"),
                'meta_json' => $metaJson,
            ]);

        });

    }

}

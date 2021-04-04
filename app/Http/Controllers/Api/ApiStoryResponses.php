<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\ApiController;
use App\Models\Stories\Story;
use App\Models\Stories\StoryResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class ApiStoryResponses extends ApiController
{

    public function store()
    {

        return $this->responseHandler(function () {

            $request = request();

            ['story_id' => $storyId] = $request->all();

            $story = Story::query()->find($storyId);

            if (!$story) {
                throw new InvalidArgumentException("Story not found.");
            }

            if (!$story->is_active) {
                throw new InvalidArgumentException("Story is inactive.");
            }

            $validator = Validator::make($request->all(), StoryResponse::getValidationRules(), StoryResponse::getCustomValidationMessages());

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $metaJson = request_meta(true);

            return StoryResponse::query()->create([
                'story_id' => $story->id,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'response_text' => $request->response_text,
                'hash' => md5("$story->id|$metaJson"),
                'meta_json' => $metaJson,
            ]);

        });

    }

}

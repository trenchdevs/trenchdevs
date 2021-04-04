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
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'response_text' => $request->response_text,
                'hash' => md5("$story->id|$metaJson"),
                'meta_json' => $metaJson,
            ]);

        });

    }

}

<?php

namespace App\Http\Controllers\Portfolio;

use App\Http\Controllers\Controller;
use App\Models\Users\UserSkill;
use App\User;
use Illuminate\Http\Request;

class UserSkillsController extends Controller
{
    public function getSkills(Request $request)
    {

        /** @var User $user */
        $user = $request->user();
        return $this->jsonResponse('success', 'Success', [
            'skills' => $user->skills,
        ]);
    }

    public function save(Request $request)
    {

        $htmlRule = 'max:10000';

        $this->validate($request, [
            'fluent' => $htmlRule,
            'conversationally_fluent' => $htmlRule,
            'tourist' => $htmlRule,
        ]);

        /** @var User $user */
        $user = $request->user();

        $skills = $user->skills;

        if (empty($skills)) {
            $skills = new UserSkill();
        }

        $skills->fill($request->all());
        $skills->user_id = $user->id;

        if ($skills->save()) {
            return $this->jsonResponse(self::STATUS_SUCCESS, 'Successfully updated skills');
        } else {
            return $this->jsonResponse(self::STATUS_ERROR, 'There was an error while saving skills');
        }
    }
}

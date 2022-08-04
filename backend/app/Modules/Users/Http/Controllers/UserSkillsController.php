<?php

namespace App\Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Users\Models\UserSkill;
use App\Modules\Users\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    /**
     * @throws ValidationException
     */
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
